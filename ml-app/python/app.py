from flask import Flask, request, jsonify
from flask_cors import CORS
import torch
from torch import Tensor
from torch.nn import Module, Linear, Sigmoid, LeakyReLU, Tanh, Sequential, MSELoss
class Network(Module):
    def __init__(self, n_of_features):
        super().__init__()
        hidden = 30
        self.layers = Sequential(
            Linear(n_of_features, hidden),
            Sigmoid(),
            Linear(hidden, 1)
        )
    def forward(self, x):
        return self.layers(x)


model = torch.load('model')
# model.eval()

city_indexes = {'Bangalore': 0, 'Chennai': 1, 'Delhi': 2, \
                'Hyderabad': 3, 'Kolkata': 4, 'Mumbai': 5}
city_dists = [
    [     0,          290,          1720,           1680,          1550,            830  ],
    [   290,            0,          1760,           1840,          1360,           1050  ],
    [  1720,         1760,             0,           1250,          1300,           1160  ],
    [  1680,         1840,          1250,              0,          2060,            850  ],
    [  1550,         1360,          1300,           2060,             0,           1650  ],
    [  830,          1050,          1160,            850,          1650,              0  ]
]

app = Flask(__name__)
CORS(app, resources={r"/getTicket": {"origins": "http://localhost:5173"}})

@app.route('/getTicket', methods=['POST'])
def get_ticket():
    data = request.get_json()

    if not data:
        return jsonify({'error': 'No input data provided'}), 400

    position = data.get('position')
    positionTo = data.get('positionTo')
    classPlane = data.get('classPlane')

    print('OUT', position, positionTo, classPlane)

    dist = city_dists[city_indexes[position]][city_indexes[positionTo]]
    cl = 0.0
    if classPlane == 'One':
        cl = 1.0

    input_data = Tensor([[cl, 1.0, 1.0, 180.0, 1.0, 0.0, 0.0, dist, -1.0, 0.0, -1.0, 0.0]])

    answer = model(input_data).item()

    # Логика обработки данных
    #print(f"Position: {position}, PositionTo: {positionTo}, ClassPlane: {classPlane}")
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
