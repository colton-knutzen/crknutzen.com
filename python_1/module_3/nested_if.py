if __name__ == '__main__':

    print("Hello. Thank you for signing up for the Programmer's Toolkit Monthly Subscription Box. \n")

    membership_plan = input("What membership level would you like? (Platinum, Gold, Silver, Bronze, or Free Trail): ")
    membership_plan = membership_plan.lower()

    payment_type = input("Will you be paying in card or cash? (There is a $2 discount with card payments): ")
    payment_type = payment_type.lower()

    if membership_plan == "platinum":
        if payment_type == "card":
            print("The Platinum membership plan costs $58")

        elif payment_type == "cash":
            print("The Platinum membership plan costs $60")

        else:
            print("Please enter a valid payment type")

    elif membership_plan == "gold":
        if payment_type == "card":
            print("The Gold membership plan costs $48")

        elif payment_type == "cash":
            print("The Gold membership plan costs $50")

        else:
            print("Please enter a valid payment type")

    elif membership_plan == "silver":
        if payment_type == "card":
            print("The Silver membership plan costs $38")

        elif payment_type == "cash":
            print("The Silver membership plan costs $40")

        else:
            print("Please enter a valid payment type")

    elif membership_plan == "bronze":
        if payment_type == "card":
            print("The Bronze membership plan costs $28")

        elif payment_type == "cash":
            print("The Bronze membership plan costs $30")

        else:
            print("Please enter a valid payment type")

    elif membership_plan == "free trail":
        print("The Free Trial is free")

    else:
        print("Please enter a valid membership plan")