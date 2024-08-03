DROP DATABASE IF EXISTS HTTPDB;

CREATE DATABASE HTTPDB;

USE HTTPDB;

CREATE TABLE address(
    id INT PRIMARY KEY AUTO_INCREMENT,
    unitNumber VARCHAR(50),
    streetNumber VARCHAR(255) NOT NULL,
    city VARCHAR(100) NOT NULL,
    stateProvince VARCHAR(255) NOT NULL,
    country VARCHAR(255) NOT NULL,
    postalCode VARCHAR(50) NOT NULL
);

CREATE TABLE person(
    id INT PRIMARY KEY AUTO_INCREMENT,
    firstName VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    phoneNumber VARCHAR(50) NOT NULL,
    addressId INT NOT NULL,
    dateOfBirth DATE NOT NULL,
    FOREIGN KEY (addressId) REFERENCES address(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE securityQuestionPool(
    id INT PRIMARY KEY AUTO_INCREMENT,
    question VARCHAR(255) NOT NULL
);

CREATE TABLE role(
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE auth(
    userName VARCHAR(100) PRIMARY KEY NOT NULL,
    password VARCHAR(64) NOT NULL,
    personId INT NOT NULL,
    secQuestion1 INT NOT NULL,
    secQ1Answer VARCHAR(255) NOT NULL,
    secQuestion2 INT NOT NULL,
    secQ2Answer VARCHAR(255) NOT NULL,
    roleId INT NOT NULL,
    FOREIGN KEY (roleId) REFERENCES role(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (secQuestion1) REFERENCES securityQuestionPool(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (secQuestion2) REFERENCES securityQuestionPool(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (personId) REFERENCES person(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE building(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    addressId INT NOT NULL,
    FOREIGN KEY (addressId) REFERENCES address(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE office(
    id INT PRIMARY KEY AUTO_INCREMENT,
    buildingId INT NOT NULL,
    roomNumber VARCHAR(50) NOT NULL,
    phoneNumber VARCHAR(100),
    FOREIGN KEY (buildingId) REFERENCES building(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE staff(
    id INT PRIMARY KEY AUTO_INCREMENT,
    officeId INT NOT NULL,
    personId INT NOT NULL,
    SSNSIN VARCHAR(100) UNIQUE NOT NULL,
    HMRN VARCHAR(100) UNIQUE NOT NULL,
    FOREIGN KEY (officeId) REFERENCES office(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (personId) REFERENCES person(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE client(
    id INT PRIMARY KEY AUTO_INCREMENT,
    personId INT UNIQUE,
    insuranceCompany VARCHAR(255) NOT NULL,
    emergencyContactId INT NOT NULL,
    clientCat ENUM('senior', 'disable'),
    FOREIGN KEY (personId) REFERENCES person(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (emergencyContactId) REFERENCES person(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE services(
    id INT AUTO_INCREMENT PRIMARY KEY,
    cost FLOAT(53) NOT NULL,
    description VARCHAR(500),
    title VARCHAR(255) NOT NULL
);

CREATE TABLE contract(
    number INT AUTO_INCREMENT PRIMARY KEY,
    clientId INT NOT NULL,
    signerId INT NOT NULL,
    signerRelationship VARCHAR(255) NOT NULL,
    patientOverallDescription VARCHAR(1024) NOT NULL,
    startDate DATE NOT NULL,
    endDate DATE NOT NULL,
    totalAmount FLOAT(53) NOT NULL,
    FOREIGN KEY (clientId) REFERENCES client(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (signerId) REFERENCES person(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE serviceContract(
    contractId INT,
    serviceId INT,
    PRIMARY KEY (contractId, serviceId),
    FOREIGN KEY (contractId) REFERENCES contract(number) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (serviceId) REFERENCES services(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE contractVisitSchedule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contractNumber INT NOT NULL,
    serviceId INT,
    scheduledVisitorId INT NOT NULL,
    visitAddressId INT NOT NULL,
    dayOfWeek ENUM(
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday'
    ),
    time TIME NOT NULL,
    FOREIGN KEY (contractNumber) REFERENCES contract(number) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (scheduledVisitorId) REFERENCES staff(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (visitAddressId) REFERENCES address(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (serviceId) REFERENCES services(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE salesTaxClass(
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(50) NOT NULL,
    valueInPercent FLOAT(50) NOT NULL
);

CREATE TABLE invoice(
    id INT PRIMARY KEY AUTO_INCREMENT,
    contractId INT NOT NULL,
    issueDate DATETIME NOT NULL,
    taxClassId INT NOT NULL,
    FOREIGN KEY (contractId) REFERENCES contract(number) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (taxClassId) REFERENCES salesTaxClass(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE payment(
    id INT PRIMARY KEY AUTO_INCREMENT,
    invoiceId INT,
    method ENUM('cash', 'pre-authorize', 'debit', 'credit'),
    date DATETIME,
    amount FLOAT(50),
    dueDate DATE,
    FOREIGN KEY (invoiceId) REFERENCES invoice(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE visit(
    id INT PRIMARY KEY AUTO_INCREMENT,
    scheduledId INT,
    submissionDate DATETIME,
    actualVisitorId INT,
    reportTitle VARCHAR(100),
    reportDescription VARCHAR(2048),
    FOREIGN KEY (scheduledId) REFERENCES contractVisitSchedule(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (actualVisitorId) REFERENCES staff(id) ON DELETE CASCADE ON UPDATE CASCADE
);