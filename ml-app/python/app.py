import numpy as np
from math import sin, cos, pi
from flask import Flask, request, jsonify
from flask_cors import CORS
from datetime import datetime, timedelta
import torch
from torch import Tensor
from torch.nn import Module, Linear, Sigmoid, Sequential
import pickle
from sklearn.preprocessing import StandardScaler, MinMaxScaler

class Network(Module):
    def __init__(self, n_of_features):
        super().__init__()
        hidden = 500
        self.layers = Sequential(
            Linear(n_of_features, hidden),
            Sigmoid(),
            Linear(hidden, 1)
        )
        self.quadratic = torch.nn.Bilinear(n_of_features, n_of_features, 1)
        self.norm = torch.nn.BatchNorm1d(X_train.shape[1])
    def forward(self, x):
        return torch.abs(self.layers(self.norm(x + self.quadratic(x, x))))

model = torch.load('model')
model.eval()

with open('scalers', 'rb') as f:
    scalers = pickle.load(f)

city_indexes = {'Bangalore': 0, 'Chennai': 1, 'Delhi': 2,
                'Hyderabad': 3, 'Kolkata': 4, 'Mumbai': 5}
city_dists = [
    [0, 290, 1720, 1680, 1550, 830],
    [290, 0, 1760, 1840, 1360, 1050],
    [1720, 1760, 0, 1250, 1300, 1160],
    [1680, 1840, 1250, 0, 2060, 850],
    [1550, 1360, 1300, 2060, 0, 1650],
    [830, 1050, 1160, 850, 1650, 0]
]

airlineNumbers = {'AirIndia': 7, 'AirAsia': 8,
                  'GO FIRST': 9, 'Indigo': 10, 'SpiceJet': 11,
                  'StarAir': 12, 'Trujet': 13, 'Vistara': 14}

app = Flask(__name__)
CORS(app)  # Позволяет запросы с любых источников, но можно настроить

@app.route('/getTicket', methods=['POST'])
def get_ticket():
    data = request.get_json()

    if not data:
        return jsonify({'error': 'No input data provided'}), 400

    position = data.get('position')
    positionTo = data.get('positionTo')
    classPlane = data.get('classPlane')
    airCompany = data.get('airCompany')
    countStops = int(data.get('countStops'))
    dataFrom = data.get('depFrom')
    dataTo = data.get('depTo')

    dist = city_dists[city_indexes[position]][city_indexes[positionTo]]
    dist = scalers[1].transform([[dist]])[0][0]
    cl = 0.0
    if classPlane == 'One':
        cl = 1.0

    dataFrom = datetime.strptime(dataFrom, '%Y-%m-%d %H:%M')
    dataTo = datetime.strptime(dataTo, '%Y-%m-%d %H:%M')

    fromAngle = (dataFrom.hour * 60 + dataFrom.minute) / (60 * 24) * 2 * pi
    toAngle = (dataTo.hour * 60 + dataTo.minute) / (60 * 24) * 2 * pi

    timeMinutes = (dataTo - dataFrom).seconds / 60.0
    timeMinutes = scalers[0].transform([[timeMinutes]])[0][0]

    input_data = torch.zeros(20)
    input_data[0] = cl
    if dataFrom.hour >= 8 and dataFrom.hour < 20:
        input_data[1] = 1
    if dataTo.hour >= 8 and dataTo.hour < 20:
        input_data[2] = 1
    input_data[3] = timeMinutes
    input_data[4 + countStops] = 1
    input_data[airlineNumbers[airCompany]] = 1
    input_data[15] = dist
    input_data[16] = cos(toAngle)
    input_data[17] = sin(toAngle)
    input_data[18] = cos(fromAngle)
    input_data[19] = sin(fromAngle)

    input_data = torch.unsqueeze(input_data, 0)

    answer = model(input_data).item()
    answer = scalers[2].inverse_transform([[answer]])[0][0]

    print(f'Price:{answer}')

    return jsonify({
        'message': 'Data received successfully',
        'data': {
            'position': position,
            'positionTo': positionTo,
            'classPlane': classPlane,
            'price': str(answer)
        }
    }), 200

if __name__ == '__main__':
    app.run(debug=True)
