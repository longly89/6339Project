import json
import re
from collections import Counter

#SPLIT REVIEWS INTO SENTENCES
def sentence_split(review):
    sentences = review.lower().split('.')

    for i in range(len(sentences)):
        sentences[i] = sentences[i].strip()

    return sentences
  
#LOADING WORDS FOR EACH CATEGORY
#[FOOD, SERVICE, DECORATION, CLEAN]
def load_word_category():
    with open('common_words','rt') as file:
        for row in file:
            text = row.strip().split("\t")
            cat = [0,0,0,0]
            if len(text) == 1:
                continue

            if 'food' in row:
                cat[0] = 1

            if 'decoration' in row:
                cat[2] = 1

            if 'service' in row:
                cat[1] = 1

            if 'clean' in row:
                cat[3] = 1

            word_category[text[0]] = cat

#LOADING SENTIMENTS DICTIONARY
def load_sentiment_dictionary():
    with open("Lexicon Dictionary.tff", 'rt') as file:
        for row in file:
            components = row.split(" ")
            word = components[2][6:]

            if 'neutral' in row:
                value = 0
            elif 'weaksubj' in row:
                if 'positive' in row:
                    value = 1
                else:
                    value = -1
            elif 'strongsubj' in row:
                if 'positive' in row:
                    value = 2
                else:
                    value = -2

            sentiments[word] = value

word_category = {}
sentiments = {}
load_word_category()
load_sentiment_dictionary()

#CONVERT RATING TO INT 0.5 = 1
def round_rate(rating):
    if rating < 0:
        neg = 1
        rating *= -1
    else:
        neg = 0

    if rating < 0.5:
        rating = 0
    elif rating < 1.5:
        rating = 1
    else:
        rating = 2

    return int((-1)**neg * rating)

#RATING SENTENCE
def rate_sentence(text):
    cat = [0,0,0,0]
    words = re.findall(r"[\'A-Za-z]+", text)

    sum_sentiment = 0
    count_sentiment = 0
    for word in words:
        if word in word_category:
            for i in range(len(cat)):
                cat[i] += word_category[word][i]
        if word in sentiments:
            sum_sentiment += sentiments[word]
            count_sentiment += 1

    #find the max
    max_cat = 0
    count = 0
    for i in range(len(cat)):
        if cat[i] > cat[max_cat]:
            max_cat = i
        elif cat[i] == cat[max_cat]:
            count += 1

    if count == 4:
        return (None, 0)

    if count_sentiment == 0:
        sentiment = 0
    else:
        sentiment = round_rate(sum_sentiment / count_sentiment) \
                    * count_neg_word(text)

    return (max_cat, sentiment)

#COUNT NEGATIVE WORD
def count_neg_word(text):
    text = text.replace("n't", " not")
    counter = Counter(text.lower().split(" "))
    neg = counter['not'] + counter['but']

    return (-1) ** neg

#RATING REVIEW
def rate_review(review_obj):
    obj = json.loads(review_obj)
    review = obj['text']
    sentences = sentence_split(review)
    categories = [0,0,0,0]
    count_cat = [0,0,0,0]
    
    for sentence in sentences:
        cat, rate = rate_sentence(sentence)
        if cat == None:
            continue
            
        count_cat[cat] += 1
        categories[cat] += rate

    for i in range(len(categories)):
        if count_cat[i] > 0:
            categories[i] = round_rate(categories[i] / count_cat[i])

    #8 slots for 4 categories
    slots = [0,0,0,0,0,0,0,0]
    for i in range(len(categories)):
        if categories[i] > 0:
            slots[i * 2] = categories[i]
        else:
            slots[i * 2 + 1] = categories[i]
            
    return (obj['business_id'], slots)

business_review = {}

with open("review_data",'rt') as file:
    for row in file:
        business_id, rate = rate_review(row)
        if business_id not in business_review:
            data = [1, rate]
            business_review[business_id] = data
        else:
            data = business_review[business_id]
            data[0] += 1
            for i in range(len(rate)):
                data[1][i] += rate[i]
            business_review[business_id] = data
            
with open("business_review", 'w') as file:
    for business in business_review:
        out = business + ',' + str(business_review[business][0])

        for i in range(len(business_review[business][1])):
            out += ',' + str(business_review[business][1][i])

        file.write(out + '\n')
