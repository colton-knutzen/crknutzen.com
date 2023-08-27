if __name__ == '__main__':

    MAX = 10
    MIN = 0

    x = 15

    print(x >= MAX)
    print(x <= MIN)

    y = 5

    if MAX > y > MIN:
        print("Y is between and does not equal Max and Min")
    else:
        print("Y is not between Max and Min, or may be equal to Max or Min")

    if MAX > y >= MIN:
        print("Y is between Max and Min or is equal to Min, but does not equal Max")
    else:
        print("Y is not between Max and Min or equal to Min, or is equal to Max")

    if MAX >= y > MIN:
        print("Y is above Min and between Min and Max, and may be equal to Max")
    else:
        print("Y is equal to Min or above Max")

