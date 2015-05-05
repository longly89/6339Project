
sentiments = {}

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

print (sentiments)
