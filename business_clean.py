import json

all_restaurant = {}
with open('restaurant_data','rt') as file:
    for row in file:
        obj = json.loads(row)
        all_restaurant[obj['business_id']] = obj

with open('business_review','rt') as inp:
    with open('restaurant_review', 'w') as out:
        for row in inp:
            data = row.strip().split(',')
            business_id = data[0]
            count = data[1]
            rating = []
            
            for i in range(2, len(data)):
                rating.append(data[i])

            obj = all_restaurant[business_id]
            obj['num_rating'] = count
            obj['rating'] = rating
            out.write(json.dumps(obj) + '\n')

