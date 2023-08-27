def switch_level(level):
    points = {'N':50, 'B':150, 'E':300, 'A': 500}
    return points.get(level, 0)

if __name__ == '__main__':
    print(switch_level("N"))
    print(switch_level("B"))
    print(switch_level("E"))
    print(switch_level("A"))
    print(switch_level("Z"))