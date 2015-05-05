import json

with open('restaurant_review','rt', encoding='utf-8') as file:
    with open('restaurant_name','w', encoding='utf-8') as out:
        for row in file:
            obj = json.loads(row)
            out.write(obj['business_id'] + "," + obj['name'] + '\n')
