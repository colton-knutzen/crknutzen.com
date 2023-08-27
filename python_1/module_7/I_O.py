def write_to_file(student_info):
    with open("student_info.txt", "a") as f:
        f.write(student_info + "\n")

def get_student_info(student_name):
    scores = []
    while True:
        test_score = input("Enter a test score (or 'end' to finish): ")
        if test_score == "end":
            break
        scores.append(int(test_score))

    student_info = (student_name, scores)
    write_to_file(str(student_info))

def read_from_file():
    with open("student_info.txt", "r") as f:
        student_info = f.read()
        print(student_info)


if __name__ == '__main__':
    open("student_info.txt", "w").close()
    get_student_info("John")
    get_student_info("Jane")
    get_student_info("Bob")
    read_from_file()


