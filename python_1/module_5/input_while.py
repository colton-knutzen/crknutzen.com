num_list = list(range(1, 101))
num_input = int(input('Please enter a number from 1 to 100: '))

if __name__ == '__main__':
 while num_input not in num_list:
    try:
        print('Number out of range. Please try again.')
        num_input = int(input('Please enter a valid number from 1 to 100: '))
    except ValueError:
        print('Invalid input. Please enter a number.')

 print(f'Correct! {num_input}')