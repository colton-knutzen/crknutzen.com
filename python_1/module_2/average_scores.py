first_name = input("Enter your First name:")
last_name = input("Enter your Last name:")
age = int(input("Enter your age:"))
score_one = int(input("Enter the test score of your first attempt:"))
score_two = int(input("Enter the test score of your second attempt:"))
score_three = int(input("Enter the test score of your third attempt:"))
average_score = (score_one + score_two + score_three) / 3

print(f'{last_name} + ", " + {first_name} + " Age: " + {age} + " Average Grade: " + {average_score:.2f}')
