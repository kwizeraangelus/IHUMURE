<?php

function seed_if_empty(): void
{
    $count = (int) db()->query('SELECT COUNT(*) FROM users')->fetchColumn();
    if ($count > 0) {
        return;
    }

    $adminPass = password_hash('Admin@2026', PASSWORD_DEFAULT);
    $counselPass = password_hash('Counsel@2026', PASSWORD_DEFAULT);
    $demoPin = password_hash('2026', PASSWORD_DEFAULT);

    q(
        'INSERT INTO users (anon_code, role, display_name, email, password_hash, district) VALUES (?,?,?,?,?,?)',
        ['IH-ADMIN1', 'admin', 'Platform Admin', 'admin@ihumure.rw', $adminPass, 'Gasabo']
    );

    q(
        'INSERT INTO users (anon_code, role, display_name, pin_hash, district) VALUES (?,?,?,?,?)',
        ['IH-DEMO01', 'consumer', 'Anonymous', $demoPin, 'Gasabo']
    );

    $counsellors = [
        [
            'code' => 'IH-C0001',
            'name' => 'Claudine Umutoni',
            'email' => 'umutoni@ihumure.rw',
            'district' => 'Gasabo',
            'category' => 'public',
            'facility' => 'CHUK Mental Health Unit',
            'fee' => 0,
            'verified' => 1,
            'bio' => 'Clinical counsellor at a public referral hospital. Supports people with harmful use and dependence. Sessions are free.',
        ],
        [
            'code' => 'IH-C0002',
            'name' => 'Jean Bosco Nsabimana',
            'email' => 'nsabimana@ihumure.rw',
            'district' => 'Huye',
            'category' => 'public',
            'facility' => 'CHUB Counselling Desk',
            'fee' => 0,
            'verified' => 1,
            'bio' => 'Public-facility counsellor focused on early screening, family support and referral into rehabilitation programmes.',
        ],
        [
            'code' => 'IH-C0003',
            'name' => 'Grace Mukamana',
            'email' => 'mukamana@ihumure.rw',
            'district' => 'Kicukiro',
            'category' => 'private',
            'facility' => 'Kigali Wellness Practice',
            'fee' => 15000,
            'verified' => 1,
            'bio' => 'Private counsellor offering structured brief interventions and recovery planning. Session fee is shown before you connect.',
        ],
        [
            'code' => 'IH-C0004',
            'name' => 'Eric Habimana',
            'email' => 'habimana@ihumure.rw',
            'district' => 'Musanze',
            'category' => 'personal',
            'facility' => 'Independent practice',
            'fee' => 8000,
            'verified' => 1,
            'bio' => 'Independent counsellor working with young adults and families affected by alcohol in the Northern Province.',
        ],
        [
            'code' => 'IH-C0005',
            'name' => 'Aline Ingabire',
            'email' => 'ingabire@ihumure.rw',
            'district' => 'Rubavu',
            'category' => 'public',
            'facility' => 'Gisenyi District Hospital',
            'fee' => 0,
            'verified' => 1,
            'bio' => 'Hospital-based counsellor. Prioritises people at likely-dependence risk and coordinates with district rehabilitation services.',
        ],
        [
            'code' => 'IH-C0006',
            'name' => 'Patrick Niyonzima',
            'email' => 'niyonzima@ihumure.rw',
            'district' => 'Rwamagana',
            'category' => 'private',
            'facility' => 'East Care Counselling',
            'fee' => 12000,
            'verified' => 0,
            'bio' => 'Pending admin verification. Certificate uploaded for review.',
        ],
    ];

    foreach ($counsellors as $c) {
        q(
            'INSERT INTO users (anon_code, role, display_name, email, password_hash, district) VALUES (?,?,?,?,?,?)',
            [$c['code'], 'counsellor', $c['name'], $c['email'], $counselPass, $c['district']]
        );
        $uid = last_id();
        q(
            'INSERT INTO counsellors (user_id, category, facility_name, verified, active, district, bio, session_fee, verified_at)
             VALUES (?,?,?,?,?,?,?,?,?)',
            [
                $uid,
                $c['category'],
                $c['facility'],
                $c['verified'],
                1,
                $c['district'],
                $c['bio'],
                $c['fee'],
                $c['verified'] ? now() : null,
            ]
        );
    }

    $articles = [
        ['faq', 'What is Ihumure?', 'Ihumure is a confidential digital health platform that helps individuals and families in Rwanda move from awareness, to a private WHO AUDIT self-screening, to certified counsellor and rehabilitation referral. You can access help without sharing your real name. Your private ID ensures your records remain confidential while allowing professional counsellors to provide continuous, compassionate care.'],
        ['faq', 'Will anyone see my name?', 'No. Consumer identity stays protected until you choose to share it. You receive a private ID (for example IH-4F8K2A) and a PIN. Screening answers are stored against that ID, not a public profile. A counsellor sees your ID and risk zone; they only see a phone number if you opt in when you request help.'],
        ['faq', 'What is the AUDIT screening?', 'AUDIT is the Alcohol Use Disorders Identification Test, a 10-question clinical assessment tool developed by the World Health Organization (WHO). Scores range from 0 to 40 and map to four risk zones: Low (0–7), Hazardous (8–15), Harmful (16–19) and Likely Dependence (20–40). Ihumure preserves all 10 clinical questions to maintain diagnostic validity.'],
        ['faq', 'What happens after I get my score?', 'Low risk: we point you to awareness resources only. Hazardous or harmful: you receive self-help tips and the option to see matched counsellors. Likely dependence: we strongly suggest connecting with a counsellor and list public facilities first. You may select one or two counsellors. Each request is private.'],
        ['faq', 'How are counsellors verified?', 'All counsellors on Ihumure are certified professionals representing public, private, or independent healthcare practices. Each practitioner undergoes credential and certificate verification by health administrators before appearing in the referral directory.'],
        ['faq', 'Is this a replacement for hospital care?', 'Ihumure provides prevention, early screening, and professional outpatient counselling referrals. If you or a loved one is in immediate physical danger, experiencing severe withdrawal symptoms, or requires medical detoxification, please visit the nearest hospital or health facility immediately. In Rwanda, district hospitals, CHUK, CHUB, and national emergency lines (112) provide 24/7 care.'],
        ['awareness', 'Alcohol and family life in Rwanda', 'Alcohol abuse remains a public health and socio-economic concern in Rwanda. It contributes to family breakdown, reduced productivity, road accidents, gender-based violence and preventable illness. Many families wait until a crisis before seeking help. Early, private screening is one way to start a conversation before harm deepens.'],
        ['awareness', 'Myths that delay help', 'Common myths include “traditional brew is not alcohol”, “only daily drinkers have a problem”, and “seeking counselling means you are weak”. AUDIT looks at pattern and harm, not only how often someone drinks. Asking for help is a practical step, not a public confession. You can start here without giving your name.'],
        ['awareness', 'How to support a loved one', 'Speak when they are sober. Describe specific behaviour, not character. Offer to sit with them while they take the screening. Do not try to police every drink. If there is violence, prioritise safety and contact local authorities or a health facility. Readers of recovery stories on this site can also request a counsellor privately.'],
        ['awareness', 'Road accidents and alcohol', 'Alcohol impairs judgement, reaction time and coordination. In Rwanda, drink-driving remains a cause of preventable injury. If your screening score is in the hazardous range or above, treat not driving after drinking as a non-negotiable rule while you seek support.'],
        ['awareness', 'What recovery can look like', 'Recovery is a personal, holistic journey. It combines clinical counselling, physical fitness, balanced nutrition, emotional wellness, family support, and community engagement. Ihumure connects you directly to certified therapists and supportive recovery resources to help you achieve sustainable wellness.'],
        ['tip', 'Keep two alcohol-free days each week', 'Pick the days in advance. Tell one trusted person. If the evenings are the hard part, plan a replacement activity: a walk, a church group, a football match, or a call.'],
        ['tip', 'Delay the first drink by one hour', 'Urge peaks and falls. Moving the first drink later in the evening often reduces total consumption without requiring a full stop on day one.'],
        ['tip', 'Do not drink on an empty stomach', 'Food slows absorption. Combined with a drink limit you set before you start, this reduces the chance of a binge occasion.'],
    ];

    foreach ($articles as $a) {
        q('INSERT INTO content (type, title, body, published) VALUES (?,?,?,1)', $a);
    }

    $demo = fetch_one("SELECT id FROM users WHERE anon_code = 'IH-DEMO01'");
    $publicCounsellor = fetch_one("SELECT c.id FROM counsellors c JOIN users u ON u.id = c.user_id WHERE u.email = 'umutoni@ihumure.rw'");
    if ($demo && $publicCounsellor) {
        q(
            'INSERT INTO screenings (user_id, answers, score, risk_zone) VALUES (?,?,?,?)',
            [$demo['id'], json_encode([1 => 3, 2 => 2, 3 => 3, 4 => 2, 5 => 2, 6 => 1, 7 => 2, 8 => 2, 9 => 2, 10 => 4]), 23, 'dependence']
        );
        $sid = last_id();
        q(
            'INSERT INTO referrals (consumer_id, counsellor_id, screening_id, risk_zone, status, share_contact, updated_at) VALUES (?,?,?,?,?,?,?)',
            [$demo['id'], $publicCounsellor['id'], $sid, 'dependence', 'acknowledged', 0, now()]
        );
        $rid = last_id();
        q(
            'INSERT INTO messages (referral_id, sender_id, sender_role, body) VALUES (?,?,?,?)',
            [$rid, $publicCounsellor['id'], 'counsellor', 'Muraho. I received your private request. You can write here without sharing your name. When would you like to talk?']
        );
        q(
            'INSERT INTO stories (user_id, title, body, approved, show_counsellor_prompt) VALUES (?,?,?,1,1)',
            [
                $demo['id'],
                'I started by telling one person',
                'I did not want anyone at home to know. A private screening was easier than walking into a hospital first. After the score I asked for a public counsellor. The chat stayed between us. I am still early, but I am no longer waiting for a crisis.',
            ]
        );
    }
}
