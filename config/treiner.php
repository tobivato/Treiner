<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Countries
    |--------------------------------------------------------------------------
    |
    | This file is for storing the countries that Treiner supports.
    |
    */

    'admin-first' => env('ADMIN_FIRST_NAME'),
    'admin-last' => env('ADMIN_LAST_NAME'),
    'admin-email' => env('ADMIN_EMAIL'),
    'admin-pass' => env('ADMIN_PASSWORD'),

    'google' => [
        'maps-api-key' => env('MAPS_API_KEY'),
    ],

    'sessions' => [
        'VirtualTraining',
        '1on1',
        'SmallGroup',
        'TeamTraining',
        'Futsal',
        'GoalkeeperTraining',
        'VideoAnalysis',
        'StrengthConditioning',
        'FootballConditioning',
        'StrikerTraining',
        'PositionSpecific',
        'SportsScience',
        'SportsPsychology',
        'FootballNutritionist',
        'FootballDietician',
        'Podiatrist',
        'Chiropractor',
        'ExercisePhysiologist',
        'SportsDoctor',
        'Physiotherapist',
        'MassageTherapist'
    ],
    'levels' => [
        'Professional',
        'SemiPro',
        'College',
        'HighSchool',
        'Youth',
        'Private'
    ],

    'player_levels' => [
        'No prior experience',
        'Miniroos',
        'Community Level',
        'NPL Level'
    ],

    'session_preference' => [
        'Half Day AM',
        'Half Day PM',
        'Full Day'
    ],

    'positions' => [
        'Goalkeeper',
        'Centreback',
        'Sweeper',
        'Fullback',
        'Wingback',
        'CentreMidfield',
        'DefensiveMidfield',
        'AttackingMidfield',
        'WideMidfield',
        'CentreForward',
        'SecondStriker',
        'Winger',
    ],

    'ages' => [
        '2_4',
        '4_6',
        '6_9',
        '9_12',
        '12_15',
        '16_20',
        '20_30',
        '30_40',
        '40_60',
        '60_70',
        '70',
    ],

    'price_ranges'=>[
        '0  - 20',
        '21 - 40',
        '41 - 60',
        '60 - 80',
        '80 - ',

    ],

    'qualifications' => [
        'None',
        'Grassroots',
        'Community',
        'CLicence',
        'BLicence',
        'ALicence',
        'ProLicence',
    ],

    'verification_types' => [
        'working_with_children_nsw',
        'working_with_children_vic',
        'working_with_children_qld',
        'working_with_children_wa',
        'working_with_children_sa',
        'working_with_children_tas',
        'working_with_children_act',
        'working_with_children_nt',
        //'working_with_children_ms',
        'fifa',
        'victorian_police_check',
        'victorian_teacher_number',
        'nz_teaching_number',
        'nz_children_check',
    ],

    'countries' => [
        'australia' => [
            'name' => 'Australia',
            'iso_2_letter' => 'AU',
            'iso_3_letter' => 'AUS',
            'phone_code' => '+61',
            'language' => 'en',
            'currency' => 'AUD',
            'aud_conversion_rate' => 1,
        ],

        'new_zealand' => [
            'name' => 'New Zealand',
            'iso_2_letter' => 'NZ',
            'iso_3_letter' => 'NZL',
            'phone_code' => '+64',
            'language' => 'en',
            'currency' => 'NZD',
            'aud_conversion_rate' => 0.96,
        ],

        'usa' => [
            'name' => 'United States',
            'iso_2_letter' => 'US',
            'iso_3_letter' => 'USA',
            'phone_code' => '+1',
            'language' => 'en',
            'currency' => 'USD',
            'aud_conversion_rate' => 1.65,
        ],

        'singapore' => [
            'name' => 'Singapore',
            'iso_2_letter' => 'SG',
            'iso_3_letter' => 'SGP',
            'phone_code' => '+65',
            'language' => 'en',
            'currency' => 'SGD',
            'aud_conversion_rate' => 0.87,
        ],

        'hong_kong' => [
            'name' => 'Hong Kong',
            'iso_2_letter' => 'HK',
            'iso_3_letter' => 'HKG',
            'phone_code' => '+852',
            'language' => 'en',
            'currency' => 'HKD',
            'aud_conversion_rate' => 0.21,
        ],

        'canada' => [
            'name' => 'Canada',
            'iso_2_letter' => 'CA',
            'iso_3_letter' => 'CAN',
            'phone_code' => '+1',
            'language' => 'en',
            'currency' => 'CAD',
            'aud_conversion_rate' => 0.86,
        ]

        /*'malaysia' => [
            'name' => 'Malaysia',
            'iso_2_letter' => 'MS',
            'iso_3_letter' => 'MYS',
            'phone_code' => '+60',
            'language' => 'ms',
            'currency' => 'MYR',
            'aud_conversion_rate' => 0.35,
        ],*/
    ],

    //Australia



    'cities' => [
        'melbourne' => [
            'name' => 'Melbourne',
            'latitude' => -37.814,
            'longitude' => 144.96332,
        ],
        'sydney' => [
            'name' => 'Sydney',
            'latitude' => -33.868820,
            'longitude' => 151.209290,
        ],
        'brisbane' => [
            'name' => 'Brisbane',
            'latitude' => -27.469770,
            'longitude' => 153.025131,
        ],
        'perth' => [
            'name' => 'Perth',
            'latitude' => -31.950527,
            'longitude' => 115.860458,
        ],
        'adelaide' => [
            'name' => 'Adelaide',
            'latitude' => -34.928497,
            'longitude' => 138.600739,
        ],
        'gold-coast' => [
            'name' => 'Gold Coast',
            'latitude' => -28.016666,
            'longitude' => 153.399994,
        ],
        'newcastle' => [
            'name' => 'Newcastle',
            'latitude' => -32.904187,
            'longitude' => 151.809082,
        ],
        'canberra' => [
            'name' => 'Canberra',
            'latitude' => -35.280781,
            'longitude' => 149.131393,
        ],
        'sunshine-coast' => [
            'name' => 'Sunshine Coast',
            'latitude' => -26.652440,
            'longitude' => 153.090300,
        ],
        'wollongong' => [
            'name' => 'Wollongong',
            'latitude' => -34.424180,
            'longitude' => 150.893550,
        ],
        'geelong' => [
            'name' => 'Geelong',
            'latitude' => -38.148000,
            'longitude' => 144.359340,
        ],
        'hobart' => [
            'name' => 'Hobart',
            'latitude' => -42.881901,
            'longitude' => 147.323807,
        ],
        'townsville' => [
            'name' => 'Townsville',
            'latitude' => -19.257620,
            'longitude' => 146.817886,
        ],
        'cairns' => [
            'name' => 'Cairns',
            'latitude' => -16.922779,
            'longitude' => 145.770294,
        ],
        'darwin' => [
            'name' => 'Darwin',
            'latitude' => -12.463440,
            'longitude' => 130.845642,
        ],
        'toowoomba' => [
            'name' => 'Toowoomba',
            'latitude' => -27.563830,
            'longitude' => 151.953970,
        ],
        'ballarat' => [
            'name' => 'Ballarat',
            'latitude' => -37.560900,
            'longitude' => 143.854970,
        ],
        'bendigo' => [
            'name' => 'Bendigo',
            'latitude' => -36.759340,
            'longitude' => 144.284000,
        ],
        'albury' => [
            'name' => 'Albury',
            'latitude' => -36.080770,
            'longitude' => 146.916540,
        ],
        'singapore' => [
            'name' => 'Singapore',
            'latitude' => 1.287953,
            'longitude' => 103.851784,
        ],
        'hong-kong' => [
            'name' => 'Hong Kong',
            'latitude' => 22.302820,
            'longitude' => 114.161308,
        ],
        'launceston' => [
            'name' => 'Launceston', 'latitude' => -41.437020, 'longitude' => 147.139390,
        ],
        'auckland' => [
            'name' => 'Auckland', 'latitude' => -36.848461, 'longitude' => 174.763336,
        ],
        'christchurch' => [
            'name' => 'Christchurch', 'latitude' => -43.532055, 'longitude' => 172.636230,
        ],
        'wellington' => [
            'name' => 'Wellington', 'latitude' => -41.286461, 'longitude' => 174.776230,
        ],
        'hamilton' => [
            'name' => 'Hamilton', 'latitude' => -37.787003, 'longitude' => 175.279251,
        ],
        'tauranga' => [
            'name' => 'Tauranga', 'latitude' => -37.687798, 'longitude' => 176.165131,
        ],
        'lower-hutt' => [
            'name' => 'Lower Hutt', 'latitude' => -41.211281, 'longitude' => 174.902252,
        ],
        'dunedin' => [
            'name' => 'Dunedin', 'latitude' => -45.878761, 'longitude' => 170.502792,
        ],
        'palmerston-north' => [
            'name' => 'Palmerston North', 'latitude' => -40.352306, 'longitude' => 175.608215,
        ],
        'napier' => [
            'name' => 'Napier', 'latitude' => -39.486359, 'longitude' => 176.919708,
        ],
        'porirua' => [
            'name' => 'Porirua', 'latitude' => -41.131490, 'longitude' => 174.839990,
        ],
        'new-plymouth' => [
            'name' => 'New Plymouth', 'latitude' => -39.056690, 'longitude' => 174.071680,
        ],
        'rotorua' => [
            'name' => 'Rotorua', 'latitude' => -38.135540, 'longitude' => 176.246994,
        ],
        'whangarei' => [
            'name' => 'Whangarei', 'latitude' => -35.725060, 'longitude' => 174.325912,
        ],
        'hibiscus-coast' => [
            'name' => 'Hibiscus Coast', 'latitude' => -36.544280, 'longitude' => 174.704530,
        ],
        'nelson' => [
            'name' => 'Nelson', 'latitude' => -41.275200, 'longitude' => 173.283997,
        ],
        'invercargill' => [
            'name' => 'Invercargill', 'latitude' => -46.411301, 'longitude' => 168.352524,
        ],
        'hastings' => [
            'name' => 'Hastings', 'latitude' => -39.642799, 'longitude' => 176.843994,
        ],
        'upper-hutt' => [
            'name' => 'Upper Hutt', 'latitude' => -41.125278, 'longitude' => 175.067841,
        ],
        'whanganui' => [
            'name' => 'Whanganui', 'latitude' => -39.931500, 'longitude' => 175.050000,
        ],
        'gisborne' => [
            'name' => 'Gisborne', 'latitude' => -38.667801, 'longitude' => 178.028000,
        ],
        'kuala-lumpur' => [
            'name' => 'Kuala Lumpur', 'latitude' => 3.139003, 'longitude' => 101.686852,
        ],
        'seberang-perai' => [
            'name' => 'Seberang Perai', 'latitude' => 5.488840, 'longitude' => 100.427650,
        ],
        'kajang' => [
            'name' => 'Kajang', 'latitude' => 2.993518, 'longitude' => 101.787407,
        ],
        'klang' => [
            'name' => 'Klang', 'latitude' => 3.092960, 'longitude' => 101.570534,
        ],
        'subang-jaya' => [
            'name' => 'Subang Jaya', 'latitude' => 3.056733, 'longitude' => 101.585121,
        ],
        'george-town' => [
            'name' => 'George Town', 'latitude' => 19.300249, 'longitude' => 81.375999,
        ],
        'ipoh' => [
            'name' => 'Ipoh', 'latitude' => 4.597479, 'longitude' => 101.090103,
        ],
        'petaling-jaya' => [
            'name' => 'Petaling Jaya', 'latitude' => 3.127887, 'longitude' => 101.594490,
        ],
        'selayang' => [
            'name' => 'Selayang', 'latitude' => 3.263739, 'longitude' => 101.653824,
        ],
        'shah-alam' => [
            'name' => 'Shah Alam', 'latitude' => 3.073281, 'longitude' => 101.518463,
        ],
        'iskandar-puteri' => [
            'name' => 'Iskandar Puteri', 'latitude' => 1.412590, 'longitude' => 103.615501,
        ],
        'seremban' => [
            'name' => 'Seremban', 'latitude' => 2.725889, 'longitude' => 101.937820,
        ],
        'johor-bahru' => [
            'name' => 'Johor Bahru', 'latitude' => 1.492659, 'longitude' => 103.741356,
        ],
        'melaka-city' => [
            'name' => 'Melaka City', 'latitude' => 2.201960, 'longitude' => 102.248528,
        ],
        'ampang-jaya' => [
            'name' => 'Ampang Jaya', 'latitude' => 3.149099, 'longitude' => 101.762451,
        ],
        'kota-kinabalu' => [
            'name' => 'Kota Kinabalu', 'latitude' => 5.980408, 'longitude' => 116.073456,
        ],
        'sungai-petani' => [
            'name' => 'Sungai Petani', 'latitude' => 5.639270, 'longitude' => 100.488083,
        ],
        'kuantan' => [
            'name' => 'Kuantan', 'latitude' => 3.822210, 'longitude' => 103.335449,
        ],
        'alor-setar' => [
            'name' => 'Alor Setar', 'latitude' => 6.124800, 'longitude' => 100.367821,
        ],
        'tawau' => [
            'name' => 'Tawau', 'latitude' => 4.24, 'longitude' => 117.89,
        ],
    ],
];
