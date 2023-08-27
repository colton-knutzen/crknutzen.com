def measurements(a_list):
    if len(a_list) == 2:
        def area(a_list):
            return a_list[0] * a_list[1]

        def perimeter(a_list):
            return 2 * (a_list[0] + a_list[1])

        perimeter_value = perimeter(a_list)
        area_value = area(a_list)
        return f"Rectangle: Perimeter = {perimeter_value} Area = {area_value}"

    else:
        def area(a_list):
            return a_list[0] * a_list[0]

        def perimeter(a_list):
            return 2 * (a_list[0] + a_list[0])

        perimeter_value = perimeter(a_list)
        area_value = area(a_list)
        return f"Square: Perimeter = {perimeter_value} Area = {area_value}"

if __name__ == '__main__':
    rectangle = [2.1, 3.4]
    result = measurements(rectangle)
    print(result)

    square = [3.5]
    result = measurements(square)
    print(result)
