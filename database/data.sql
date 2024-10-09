USE gofuel;

INSERT INTO
    `categories`
VALUES (1, 'Gasoline'),
    (2, 'Diesel'),
    (3, 'Snacks'),
    (4, 'Accessories');

INSERT INTO
    `item_stocks`
VALUES (1, 1, 5000),
    (2, 2, 3000),
    (3, 3, 7000),
    (4, 4, 4000),
    (5, 5, 200),
    (6, 6, 500),
    (7, 7, 100),
    (8, 8, 50);

INSERT INTO
    `items`
VALUES (1, 'Unleaded 95 - 1L', 1.5, 1),
    (2, 'Unleaded 98 - 1L', 1.7, 2),
    (
        3,
        'Diesel Regular - 1L',
        1.4,
        3
    ),
    (
        4,
        'Diesel Premium - 1L',
        1.6,
        4
    ),
    (5, 'Pack of Chips', 2.5, 5),
    (6, 'Soda Can', 1, 6),
    (7, 'Car Freshener', 3, 7),
    (8, 'Car Charger', 8, 8);

INSERT INTO
    `stations`
VALUES (
        1,
        'Station 1',
        '123 Main St',
        '1000-001',
        2
    ),
    (
        2,
        'Station 2',
        '456 Market Ave',
        '1000-002',
        2
    ),
    (
        4,
        'Test Station',
        'Rua de Teste',
        '2365-875',
        2
    );

INSERT INTO
    `subcategories`
VALUES (1, 'Unleaded 95', 1),
    (2, 'Unleaded 98', 1),
    (3, 'Diesel Regular', 2),
    (4, 'Diesel Premium', 2),
    (5, 'Chips', 3),
    (6, 'Soda', 3),
    (7, 'Car Fresheners', 4),
    (8, 'Car Chargers', 4);

INSERT INTO
    `user_info`
VALUES (
        1,
        7,
        123456789,
        'Admin',
        'Admin User',
        'Rua Admin 1',
        '1000-001',
        ''
    ),
    (
        2,
        8,
        987654321,
        'Manager',
        'Manager User',
        'Rua Manager 2',
        '1000-002',
        ''
    ),
    (
        3,
        9,
        123789456,
        'In Charge',
        'In Charge User',
        'Rua InCharge 3',
        '1000-003',
        ''
    ),
    (
        4,
        10,
        456123789,
        'Employee',
        'Employee User',
        'Rua Employee 4',
        '1000-004',
        ''
    );

INSERT INTO
    `station_items`
VALUES (2, 4, 5, 1.3),
    (3, 4, 5, 1.3);

INSERT INTO
    `pumps`
VALUES (1, 1),
    (2, 1),
    (3, 2),
    (4, 2),
    (5, 3),
    (6, 3);