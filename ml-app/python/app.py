from flask import Flask, request, jsonify

app = Flask(__name__)

@app.route('/add-book', methods=['POST'])
def add_book():
    data = request.get_json()

    if not data:
        return jsonify({'error': 'No input data provided'}), 400

    position = data.get('position')
    positionTo = data.get('positionTo')
    classPlane = data.get('classPlane')

    # Логика обработки данных
    print(f"Position: {position}, PositionTo: {positionTo}, ClassPlane: {classPlane}")

    return jsonify({'message': 'Data received successfully'}), 200

if __name__ == '__main__':
    app.run(debug=True)