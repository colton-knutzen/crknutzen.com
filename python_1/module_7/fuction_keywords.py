def average_scores(*args, **kwargs):
    total = sum(args)
    average = total / len(args)

    # for key, value in kwargs.items():
        # print("%s == %s" % (key, value))

    return f"Result: Name = {kwargs['first_name']} {kwargs['last_name']}, GPA = {average}, Course = {kwargs['major']}"

if __name__ == '__main__':
    print(average_scores(4, 3, 2, 4, first_name='Michelle', last_name='Ruse', major='Python'))
    print(average_scores(4, 3, 2, 4, 2, 1, 3, first_name='Jill', last_name='Dane', major='CSS'))
    print(average_scores(4, 1, first_name='John', last_name='Doe', major='HTML'))