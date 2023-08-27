def get_input():
    try:
        user_input = int(input("Please enter a full number: "))
        return user_input
    except ValueError:
        print("Invalid input. Please enter a valid number.")
def make_list(num):
    num_list = []
    for _ in range(num):
        num_list.append(get_input())
    return num_list

if __name__ == '__main__':
    print(make_list(1))
    print(make_list(2))
    print(make_list(3))