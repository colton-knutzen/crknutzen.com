class BankAccount {
    accountNumber;
    accountName;

    constructor(inBalance) {
        this.accountBalance = inBalance;
    }


    //I'm missing the point of these because they aren't doing anything in my code.

    /*get accountNumber() {
        return this.accountNumber;
    }

    set accountNumber(accountNumber) {
        this.accountName = accountNumber;
    }

    get accountName() {
        return this.accountName;
    }

    set accountName(accountName) {
        this.accountName = accountName;
    }*/

    deposit(amount){
        this.accountBalance += amount; //this adds whatever amount was passed through to the account balance
        amount = Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(amount); //this converts the deposited amount to us currency formate
        return "You have successfully deposited " + amount + ". " + "Your Current Balance is: " + this.balance(); //this returns the amount deposited, in US currency, as well as the new balance

    }

    withdraw(amount){
        this.accountBalance -= amount; //same as deposit, just with subtraction
        amount = Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(amount);
        return "You have successfully withdrew " + amount + ". " + "Your Current Balance is: " + this.balance();
    }

    balance(){
        return "$" + this.accountBalance;
        //= Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(accountBalance);
        //The currency converter wasn't working for this function for some reason
    }

    accountInfo(){
        return "Welcome " + this.accountName + ". You're Account Number is " + this.accountNumber + ". And Current Balance is: "  + this.balance(); //This is the greeting message when user logs on
    }
}