-- ➡️  Utilisateurs
INSERT INTO
    `user` (
        username,
        avatar,
        email,
        password,
        `role`,
        created_at
    )
VALUES
    (
        'Sulyvane',
        'sulyvane.png',
        'sulyvane@example.com',
        '$2y$10$2RWot3AW6eFNeRXKDfZNAuqZHu8y/RzFExt2yD0dku/.i1upXbDWG',
        '["ROLE_USER"]',
        '2025-01-15 10:22:00'
    ),
    (
        'Leo',
        'Leo.jpg',
        'Leo@example.com',
        '$2y$10$2RWot3AW6eFNeRXKDfZNAuqZHu8y/RzFExt2yD0dku/.i1upXbDWG',
        '["ROLE_USER"]',
        '2025-01-16 09:04:00'
    ),
    (
        'Jean-Baptiste',
        'Jean-Baptiste.jpg',
        'Jean-Baptiste@example.com',
        '$2y$10$2RWot3AW6eFNeRXKDfZNAuqZHu8y/RzFExt2yD0dku/.i1upXbDWG',
        '["ROLE_USER"]',
        '2025-02-03 14:37:00'
    ),
    (
        'Frederic',
        'Frederic.png',
        'Frederic@example.com',
        '$2y$10$2RWot3AW6eFNeRXKDfZNAuqZHu8y/RzFExt2y0dku/.i1upXbDWG',
        '["ROLE_USER"]',
        '2025-02-11 18:20:00'
    ),
    (
        'Jonathan',
        'Jonathan.jpg',
        'Jonathan@example.com',
        '$2y$10$2RWot3AW6eFNeRXKDfZNAuqZHu8y/RzFExt2yD0dku/.i1upXbDWG',
        '["ROLE_USER"]',
        '2025-03-01 08:42:00'
    ),
    (
        'Nathalie',
        'Nathalie.png',
        'Nathalie@example.com',
        '$2y$10$2RWot3AW6eFNeRXKDfZNAuqZHu8y/RzFExt2yD0dku/.i1upXbDWG',
        '["ROLE_USER"]',
        '2025-03-07 19:11:00'
    ),
    (
        'Magalie',
        'Magalie.jpg',
        'Magalie@example.com',
        '$2y$10$2RWot3AW6eFNeRXKDfZNAuqZHu8y/RzFExt2yD0dku/.i1upXbDWG',
        '["ROLE_USER"]',
        '2025-04-05 12:05:00'
    ),
    (
        'Nicolas',
        'Nicolas.jpg',
        'Nicolas@example.com',
        '$2y$10$2RWot3AW6eFNeRXKDfZNAuqZHu8y/RzFExt2yD0dku/.i1upXbDWG',
        '["ROLE_USER"]',
        '2025-04-05 12:05:00'
    ),
    (
        'Thomas',
        'Thomas.jpg',
        'Thomas@example.com',
        '$2y$10$2RWot3AW6eFNeRXKDfZNAuqZHu8y/RzFExt2yD0dku/.i1upXbDWG',
        '["ROLE_USER"]',
        '2025-04-05 12:05:00'
    ),
    (
        'Nadia',
        'Nadia.jpg',
        'Nadia@example.com',
        '$2y$10$2RWot3AW6eFNeRXKDfZNAuqZHu8y/RzFExt2yD0dku/.i1upXbDWG',
        '["ROLE_USER"]',
        '2025-04-05 12:05:00'
    ),
    (
        'Hugo',
        'Hugo.jpg',
        'Hugo@example.com',
        '$2y$10$2RWot3AW6eFNeRXKDfZNAuqZHu8y/RzFExt2yD0dku/.i1upXbDWG',
        '["ROLE_USER"]',
        '2025-04-05 12:05:00'
    ),
    (
        'Christophe',
        'Christophe.jpg',
        'Christophe@example.com',
        '$2y$10$2RWot3AW6eFNeRXKDfZNAuqZHu8y/RzFExt2yD0dku/.i1upXbDWG',
        '["ROLE_USER"]',
        '2025-04-05 12:05:00'
    ),
    (
        'Bryan',
        'Bryan.jpg',
        'Bryan@example.com',
        '$2y$10$2RWot3AW6eFNeRXKDfZNAuqZHu8y/RzFExt2yD0dku/.i1upXbDWG',
        '["ROLE_USER"]',
        '2025-04-20 16:33:00'
    );

-- ➡️  Compétences
INSERT INTO
    skill (
        id_user,
        title,
        infos,
        etat,
        created_at,
        updated_at
    )
VALUES
    (
        1,
        'Guitare – niveau débutant',
        'Cours acoustique, méthode douce',
        'offer',
        '2025-02-01 11:00:00',
        NULL
    ),
    (
        1,
        'Espagnol conversationnel',
        'Je cherche un tandem 1 h/semaine',
        'request',
        '2025-02-02 09:00:00',
        NULL
    ),
    (
        2,
        'Tableur Excel avancé',
        'Macros, TCD, automatisation',
        'offer',
        '2025-02-10 08:30:00',
        NULL
    ),
    (
        2,
        'Cuisine japonaise',
        'Je veux apprendre les bases des ramen',
        'request',
        '2025-02-12 14:15:00',
        NULL
    ),
    (
        3,
        'Photographie portrait',
        'Séances extérieures, reflex ou mirrorless',
        'offer',
        '2025-02-15 15:20:00',
        NULL
    ),
    (
        3,
        'Piano jazz – débutant',
        'Cours d’initiation 30 min',
        'request',
        '2025-02-16 16:40:00',
        NULL
    ),
    (
        4,
        'Développement web (HTML/CSS)',
        'Ateliers de 2 h le week-end',
        'offer',
        '2025-03-05 10:00:00',
        NULL
    ),
    (
        4,
        'Conversation anglaise',
        'Je cherche à pratiquer 2 h/semaine',
        'request',
        '2025-03-06 10:05:00',
        NULL
    ),
    (
        5,
        'Yoga Vinyasa',
        'Cours en petit groupe, tout niveau',
        'offer',
        '2025-03-10 07:30:00',
        NULL
    ),
    (
        5,
        'Illustration numérique Procreate',
        'Besoin de conseils techniques',
        'request',
        '2025-03-10 07:40:00',
        NULL
    ),
    (
        6,
        'Plomberie de base',
        'Je propose d’apprendre à changer un joint',
        'offer',
        '2025-03-15 17:00:00',
        NULL
    ),
    (
        6,
        'Accordéon – niveau avancé',
        'Je cherche un partenaire de duos',
        'request',
        '2025-03-16 18:00:00',
        NULL
    ),
    (
        7,
        'Cuisine japonaise',
        'Je partage mes recettes gyoza/ramen',
        'offer',
        '2025-04-08 13:30:00',
        NULL
    ),
    (
        7,
        'Excel débutant',
        'Besoin d’aide pour formules basiques',
        'request',
        '2025-04-08 13:45:00',
        NULL
    ),
    (
        8,
        'Développement Java',
        'Sessions de pair-programming',
        'offer',
        '2025-04-22 19:30:00',
        NULL
    ),
    (
        8,
        'Yoga Vinyasa',
        'Je cherche un prof 1 h/semaine',
        'request',
        '2025-04-22 19:35:00',
        NULL
    );

-- ➡️  Demandes d’échange
INSERT INTO
    `exchange` (
        id_user,
        id_skill,
        etat,
        infos,
        created_at,
        updated_at
    )
VALUES
    (
        2,
        1,
        'accepted',
        'Séance test prévue samedi',
        '2025-02-20 11:00:00',
        '2025-02-22 10:00:00'
    ),
    (
        1,
        3,
        'completed',
        '3 sessions terminées',
        '2025-02-25 18:00:00',
        '2025-03-10 18:00:00'
    ),
    (
        4,
        15,
        'pending',
        'Proposition envoyée',
        '2025-05-02 12:00:00',
        NULL
    ),
    (
        3,
        9,
        'completed',
        'Shooting au parc terminé',
        '2025-04-02 09:00:00',
        '2025-04-04 12:30:00'
    ),
    (
        7,
        4,
        'accepted',
        'Cours ramen #1 planifié',
        '2025-04-12 15:00:00',
        '2025-04-14 09:00:00'
    );

-- ➡️  Notes sur les échanges terminés
INSERT INTO
    rating (
        id_exchange,
        id_user,
        rating_value,
        commentaire,
        created_at,
        updated_at
    )
VALUES
    (
        2,
        1,
        5,
        'Pédagogue, très clair dans ses explications !',
        '2025-03-11 10:00:00',
        NULL
    ),
    (
        4,
        5,
        4,
        'Super shooting, j’aurais juste aimé plus de conseils',
        '2025-04-05 18:00:00',
        NULL
    ),
    (
        4,
        3,
        5,
        'Très à l’aise devant l’objectif, top !',
        '2025-04-05 18:10:00',
        NULL
    );