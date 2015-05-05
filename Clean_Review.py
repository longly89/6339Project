import json
import re
from collections import Counter
from random import randint

N = 3000
#get randomly N review to train
ran = []
while len(ran) < N:
    k = randint(0, 452000)
    if k not in ran:
        ran.append(k)

ran.sort()
reviews = []
long_text = ""
count = 0

with open("review_data", "rt") as file:
    for row in file:
        if count in ran:
            reviews.append(row)

        count += 1

print(len(reviews))

with open("train_data", "w") as out:
    for text in reviews:
        out.write(text)
