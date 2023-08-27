list = [1, 13, 51, 12, 3, 4]

def sort_list_return():
    list.sort()
    return list
    # return is required here because the the new sorted list needs to return down in the main where it was called, so it can be printed

def sort_list():
    list.sort()
    print(list)
    # here is not required, because we are printing the list from within the function, rather than where the function was called

def search_list_return():
    index = list.index(51)
    return index
    # just like with .sort, return is used here because we are printing where the function was called.
    # Also, 51 is returning at an index of 5, because the list has already been sorted by the time it's indexed.

def search_list():
    index = list.index(51)
    print(index)

if __name__ == '__main__':
    print(f"This is the original list: {list}")
    print(f"This is .sort list that requires return: {sort_list_return()}")
    print(f"This is .search list that requires return: {search_list_return()}")

    print("\n")

    sort_list()
    search_list()