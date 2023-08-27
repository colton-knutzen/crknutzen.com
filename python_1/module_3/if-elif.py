if __name__ == '__main__':

    print("Hello. Thank you for signing up for the Programmer's Toolkit Monthly Subscription Box. \n")

    membership_plan = input("What membership level would you like? (Platinum, Gold, Silver, Bronze, or Free Trail): ")

    membership_plan = membership_plan.lower()

    if membership_plan == "platinum":
        print("The Platinum membership plan costs $60")

    elif membership_plan == "gold":
        print("The Gold membership plan costs $50")

    elif membership_plan == "silver":
        print("The Silver membership plan costs $40")

    elif membership_plan == "bronze":
        print("The Bronze membership plan costs $30")

    elif membership_plan == "free trail":
        print("The Free Trial is free")

    else:
        print("Please enter a valid membership plan")
