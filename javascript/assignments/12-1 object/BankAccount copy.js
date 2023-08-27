class BankAccount {
    //list of properties for this class
    accountBalance;
    accountNumber;
    accountName;

    //constructor for accountBalance to accept parameter inBalance
    constructor(inBalance) {
        this.accountBalance = inBalance;
    }

    set deposit(deposit) {
        this.accountBalance = deposit;
    }

    set withdraw(withdraw) {
        this.accountBalance = withdraw;
    }

    get balance() {
        return this.accountBalance;
    }

    get accountInfo() {
        return this.studentName + ", " + this.studentEmail;
    }

}
