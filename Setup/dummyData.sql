USE HTTPDB;

INSERT INTO
    address (
        unitNumber,
        streetNumber,
        city,
        stateProvince,
        country,
        postalCode
    )
VALUES
    (
        '10A',
        '123 Main St',
        'Vancouver',
        'BC',
        'Canada',
        'V5K0A1'
    ),
    (
        '20B',
        '456 Elm St',
        'Richmond',
        'BC',
        'Canada',
        'V6Y3A2'
    ),
    (
        '30C',
        '789 Oak St',
        'Burnaby',
        'BC',
        'Canada',
        'V5H1X3'
    );

INSERT INTO
    person (
        firstName,
        lastName,
        phoneNumber,
        addressId,
        dateOfBirth
    )
VALUES
    ('John', 'Doe', '6041234567', 1, '1980-01-01'),
    ('Jane', 'Smith', '6049876543', 2, '1990-02-02'),
    (
        'Alice',
        'Johnson',
        '6044567890',
        3,
        '1975-03-03'
    );

INSERT INTO
    securityQuestionPool (question)
VALUES
    ('What is your mother\'s maiden name?'),
    ('What was the name of your first pet?');

INSERT INTO
    role (title)
VALUES
    ('staff'),
    ('visitor'),
    ('client');

INSERT INTO
    auth (
        userName,
        password,
        personId,
        secQuestion1,
        secQ1Answer,
        secQuestion2,
        secQ2Answer,
        roleId
    )
VALUES
    (
        'staff',
        '$2y$10$RayRTeUWrFFsXC58I46sT.n6ez8C7f9HH2r3uWKAIilj0k6vQMKD2',
        1,
        1,
        'Smith',
        2,
        'Fluffy',
        1
    ),
    (
        'client',
        '$2y$10$RayRTeUWrFFsXC58I46sT.n6ez8C7f9HH2r3uWKAIilj0k6vQMKD2',
        2,
        1,
        'Johnson',
        2,
        'Buddy',
        3
    ),
    (
        'visitor',
        '$2y$10$RayRTeUWrFFsXC58I46sT.n6ez8C7f9HH2r3uWKAIilj0k6vQMKD2',
        3,
        1,
        'Doe',
        2,
        'Charlie',
        2
    );

INSERT INTO
    building (name, addressId)
VALUES
    ('Building A', 1),
    ('Building B', 2);

INSERT INTO
    office (buildingId, roomNumber, phoneNumber)
VALUES
    (1, '101', '6041112222'),
    (2, '202', '6043334444');

INSERT INTO
    staff (officeId, personId, SSNSIN, HMRN)
VALUES
    (1, 1, '123-45-6789', 'H123'),
    (2, 2, '987-65-4321', 'H456');

INSERT INTO
    client (
        personId,
        insuranceCompany,
        emergencyContactId,
        clientCat
    )
VALUES
    (3, 'ABC Insurance', 1, 'senior');

INSERT INTO
    services (cost, description, title)
VALUES
    (
        100.00,
        'Basic health check-up',
        'Health Check-Up'
    ),
    (
        200.00,
        'Comprehensive health check-up',
        'Comprehensive Check-Up'
    );

INSERT INTO
    contract (
        clientId,
        signerId,
        signerRelationship,
        patientOverallDescription,
        startDate,
        endDate,
        totalAmount
    )
VALUES
    (
        1,
        2,
        'daughter',
        'Patient requires regular monitoring',
        '2024-01-01',
        '2025-01-01',
        1000.00
    );

INSERT INTO
    contractVisitSchedule (
        contractNumber,
        serviceId,
        scheduledVisitorId,
        visitAddressId,
        dayOfWeek,
        time
    )
VALUES
    (1, 1, 1, 1, 'monday', '09:00:00'),
    (1, 2, 2, 2, 'wednesday', '10:00:00');

INSERT INTO
    salesTaxClass (title, valueInPercent)
VALUES
    ('GST', 5.00),
    ('PST', 7.00);

INSERT INTO
    invoice (contractId, issueDate, taxClassId)
VALUES
    (1, '2024-01-15 10:00:00', 1);

INSERT INTO
    payment (invoiceId, method, date, amount, dueDate)
VALUES
    (
        1,
        'credit',
        '2024-01-20 12:00:00',
        500.00,
        '2024-01-31'
    );

INSERT INTO
    visit (
        scheduledId,
        submissionDate,
        actualVisitorId,
        reportTitle,
        reportDescription
    )
VALUES
    (
        1,
        '2024-01-10 14:00:00',
        1,
        'Visit Report',
        'The patient is stable and no new issues were noted.'
    );