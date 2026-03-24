import sys
import os
import joblib
import numpy as np
import warnings

# This line hides the VersionWarnings so the UI stays clean
warnings.filterwarnings("ignore", category=UserWarning)

def predict():
    try:
        base_path = os.path.dirname(os.path.abspath(__file__))
        # Ensure you are loading the Random Forest model
        model = joblib.load(os.path.join(base_path, 'sonar_rf_model.pkl'))

        if len(sys.argv) < 2:
            return

        raw_data = sys.argv[1].replace('[', '').replace(']', '').strip()
        data_list = [float(x.strip()) for x in raw_data.split(',')]
        
        input_array = np.array(data_list).reshape(1, -1)
        prediction = model.predict(input_array)
        
        # 'M' is Fish/Mine; 'R' is Rock
        if str(prediction[0]).strip() == 'M':
            print("Fish")
        else:
            print("Rock")
            
    except Exception as e:
        print(f"Error: {str(e)}")

if __name__ == "__main__":
    predict()