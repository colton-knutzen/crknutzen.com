import array as arr


def sort_array(a2):
    normal_list = a2.tolist()
    normal_list.sort()
    return normal_list


def search_array(a2, value):
    try:
        return a2.index(value)
    except ValueError:
        return -1


if __name__ == '__main__':
    a = arr.array('b', [1, 4, 15, 3, 9, 12, 2, 56, 5, 92, 8])

    print(search_array(a, 3))
    print(search_array(a, 56))
    print(search_array(a, 7))

    print(sort_array(a))
