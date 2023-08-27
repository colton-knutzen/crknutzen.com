from abc import ABC, abstractmethod


class Pet(ABC):
    @abstractmethod
    def move(self):
        pass

    @abstractmethod
    def noise(self):
        pass


class Pig(Pet):
    def move(self):
        return "Wilbert rolls in the mud"

    def noise(self):
        return "Okie"


class Snake(Pet):
    def move(self):
        return "Serpent slithers across the grass"

    def noise(self):
        return "Hiss"


class Hippo(Pet):
    def move(self):
        return "Hippo chomps at the air"

    def noise(self):
        return "Yawn"


if __name__ == '__main__':
    pig = Pig()
    snake = Snake()
    hippo = Hippo()

    print(pig.move())
    print(pig.noise())
    print("\n")
    print(snake.move())
    print(snake.noise())
    print("\n")
    print(hippo.move())
    print(hippo.noise())


# This makes even less sense for what the Parent class is supposed to be contributing to the Child class, except maybe
# giving them "placeholder" methods so it'll throw an error if they are forgotten in the Child classes?
# I understand how to do them and the thought process behind them, but I can't think of any real reason to use them unless
# the parent class has like hundreds of members that will be used by multiple Child classes. But those Child classes
# still have in include all those hundreds of members in the constructor. The only place it could save time and lines
# would be in the super().__init__(member 1, member 2, etc)