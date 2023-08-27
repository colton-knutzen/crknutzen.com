import sqlite3
from sqlite3 import Error


def create_connection(db):
    """ Connect to a SQLite database
    :param db: filename of database
    :return connection if no error, otherwise None"""
    try:
        conn = sqlite3.connect(db)
        return conn
    except Error as err:
        print(err)
    return None


def create_table(conn, sql_create_table):
    """ Creates table with give sql statement
    :param conn: Connection object
    :param sql_create_table: a SQL CREATE TABLE statement
    :return:
    """
    try:
        c = conn.cursor()
        c.execute(sql_create_table)
    except Error as e:
        print(e)


def create_tables(database):
    sql_create_person_table = """ CREATE TABLE IF NOT EXISTS person (
                                        id integer PRIMARY KEY,
                                        firstname text NOT NULL,
                                        lastname text NOT NULL
                                    ); """

    sql_create_student_table = """CREATE TABLE IF NOT EXISTS student (
                                    id integer PRIMARY KEY,
                                    major text NOT NULL,
                                    begin_date text NOT NULL,
                                    end_date text,
                                    FOREIGN KEY (id) REFERENCES person (id)
                                );"""

    # create a database connection
    conn = create_connection(database)
    if conn is not None:
        # create person table
        create_table(conn, sql_create_person_table)
        # create student table
        create_table(conn, sql_create_student_table)
    else:
        print("Unable to connect to " + str(database))


def create_person(conn, person):
    """Create a new person for table
    :param conn:
    :param person:
    :return: person id
    """
    sql = ''' INSERT INTO person(firstname,lastname)
              VALUES(?,?); '''
    cur = conn.cursor()  # cursor object
    cur.execute(sql, person)
    return cur.lastrowid  # returns the row id of the cursor object, the person id


def create_student(conn, student):
    """Create a new person for table
    :param conn:
    :param student:
    :return: student id
    """
    sql = ''' INSERT INTO student(id, major, begin_date)
              VALUES(?,?,?); '''
    cur = conn.cursor()  # cursor object
    cur.execute(sql, student)
    return cur.lastrowid  # returns the row id of the cursor object, the student id


def select_all_persons(conn):
    """Query all rows of person table
    :param conn: the connection object
    :return:
    """
    cur = conn.cursor()
    cur.execute("SELECT * FROM person;")

    rows = cur.fetchall()

    return rows  # return the rows


def select_all_students(conn):
    """Query all rows of student table
    :param conn: the connection object
    :return:
    """

    cur = conn.cursor()
    cur.execute("SELECT * FROM student;")

    rows = cur.fetchall()

    return rows


if __name__ == '__main__':
    connection = create_connection("python_sqlite.db")
    create_tables("python_sqlite.db")
    with connection:
        connection.execute("DELETE FROM person;")
        connection.execute("DELETE FROM student;")
        connection.commit()

        person1 = ('Rob', 'Thomas')
        person_id1 = create_person(connection, person1)

        person2 = ('Jill', 'Lorde')
        person_id2 = create_person(connection, person2)

        person3 = ('Jack', 'Smith')
        person_id3 = create_person(connection, person3)

        rows = select_all_persons(connection)
        for row in rows:
            print(row)

        student1 = (person_id1, 'Songwriting', '2000-01-01')
        student_id1 = create_student(connection, student1)

        student2 = (person_id2, 'Actor', '2005-06-03')
        student_id2 = create_student(connection, student2)

        student3 = (person_id3, 'Director', '2010-07-08')
        student_id3 = create_student(connection, student3)

        rows = select_all_students(connection)
        for row in rows:
            print(row)
