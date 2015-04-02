import json

data = []

with open("../Yelp Data/yelp_academic_dataset_business.json", "rt") as file:
    with open("business_data", "w") as output:
        for row in file:
            obj = json.loads(row)
            cat = obj['categories']
            if ('Restaurants' in obj['categories']):
                output.write(row)
                data.append(obj['business_id'])
                
with open("../Yelp Data/yelp_academic_dataset_review.json", "rt") as file:
    with open("review_data", "w") as out:
        for row in file:
            obj = json.loads(row)
            if obj['business_id'] in data and obj['votes']['useful'] > 0:
                out.write(row)
            