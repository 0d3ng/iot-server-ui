from pathlib import Path

# TELEGRAM BOT URL (CHANGE HERE)
bot_url = "https://api.telegram.org/bot1610649594:AAGR4uowEf_7we16hQDf4FYfVHEn5CbZKNw/"

# LOG FILE (CHANGE HERE)
LOG_FILE = "experiment_moving_0208.csv"
LOG_FILE6 = "onbody-0324-oldmqtt.csv"
# Detection interval
PERIOD = 30  # duration in seconds

# CSV fingerprint file
TRAIN_FILE = Path("fingerprint_23F_ultimate.csv")
TRAIN_FILE6 = Path("fingerprint_23F_6rcv.csv")#("fingerprint-6receivers-initial.csv")
#TRAIN_FILE = Path("fingerprint_3F_5R_optkaku.csv")
#TRAIN_FILE = Path("fingerprint-2F3F-optimized.csv")
#TRAIN_FILE = Path("fingerprint_thirdfloor5.csv")

# PATH
path = "E:/Laboratory/Lab Meeting/Bahan/FILS15.4-6R/"  # change here!  D:/DOCTOR/Research/Lab Meet/Bahan/FILS15.4-6R/

# DETECTE FILE (not use this)
DETECT_FILE = "DetectedRoom.csv"

# DATABASE FILE (CHANGE HERE)
database = "online.db" # server.db untuk deteksi per lantai, dualantai.db untuk deteksi 2F3F
database6 = "online6.db" #database for 6 receivers

# BROKER SETUP (CHANGE HERE)
# broker_address = "test.mosquitto.org"
#broker_address = "broker.hivemq.com"
broker_address = "broker.emqx.io"
#broker_address = "103.106.72.188"
port = 1883
