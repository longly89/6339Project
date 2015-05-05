import re
import json
from stop_words import get_stop_words

stop_words = get_stop_words('en')
dic = {}

with open('train_data','rt') as file:
    for row in file:
        content = json.loads(row)
        text = content['text'].lower()
        all_words = re.findall(r"[\'A-Za-z]+", text)
        
        #words = [word for word in all_words if word not in stop_words]
        
        for word in all_words:
            if word in dic:
                dic[word] += 1
            else:
                dic[word] = 1

        
common_words = []

for word in dic:
    if dic[word] > 50:
        common_words.append(word)

common_words.sort()

with open('common_words','w') as file:
    for word in common_words:
        file.write(word + '\n')
