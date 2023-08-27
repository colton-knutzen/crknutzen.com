class Student{

    //list of properties for the class
    //constructor method
    //setters and getters methods
    //processing methods

    studentName;
    studentEmail;

    constructor(inName){
        this.studentName = inName;
    }

    //set method accepts in input value and stores in property of the class/object
    set StudentName(inName){
        this.studentName = inName;      //assign input value to a property of the class/object
    }

    get StudentName(){
        return this.studentName;        //return a value stored in the class/object
    }

    //processing methods - work with the content of the object

    displayStudentInfo(){
        return this.studentName + ", " + this.studentEmail;
    }

}