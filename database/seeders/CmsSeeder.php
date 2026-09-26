<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class CmsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Pages
        $pages = [
            [
                'title' => 'How Hahakar Works',
                'slug' => 'how-it-works',
                'content' => "## How Hahakar Works\n\nHahakar is Nepal's premier vehicle rental comparison and direct booking network. We connect travelers directly with verified local drivers, vehicle owners, and licensed Nepali fleet operators (such as Himalayan Car Rental, Kathmandu Wheels, Pokhara Drive Co., Everest Tour Fleet, and Annapurna Safari Fleets).\n\n### 1. Search Nepal Inventory\nSelect your pickup hub (Kathmandu, Pokhara, Chitwan, Lumbini, Biratnagar, or Nepalgunj), dates, and preferred service mode (With Driver / Self-Drive).\n\n### 2. Compare Verified Vehicles\nFilter by vehicle type (4WD Scorpio, Hilux, Creta, Swift, HiAce Tourist Van, EV), transmission, luggage space, and seating capacity with transparent NPR rates.\n\n### 3. Book Direct with Instant Confirmation\nConfirm your reservation without upfront payment. Receive your digital voucher and pay directly upon vehicle handover.",
                'meta_title' => 'How It Works - Nepal Car Rental & Direct Booking | Hahakar',
                'meta_description' => 'Learn how Hahakar connects you with verified Nepal car rental fleets and drivers with transparent NPR pricing.',
            ],
            [
                'title' => 'About Hahakar Nepal',
                'slug' => 'about',
                'content' => "## Empowering Nepal's Ground Mobility & Travel

*Nepal's Premier Car Rental Metasearch Engine & Direct Booking Network*

Welcome to **Hahakar Nepal**, the dedicated mobility ecosystem built to bring absolute transparency, safety, and modern digital reliability to vehicle rentals and road travel across the Federal Democratic Republic of Nepal.

From navigating the ancient heritage streets of Kathmandu and the serene lakeside trails of Pokhara to embarking on rugged, high-altitude 4WD expeditions across the Himalayas of Mustang, Manang, and Rara Lake, Hahakar bridges the gap between verified local fleet operators, independent Nepali drivers, and global travelers.

---

### Our Story & The Problem We Solved
For decades, renting a vehicle in Nepal involved dealing with opaque offline broker networks, inconsistent pricing, unverified vehicle bluebooks, surprise counter surcharges, and uncertainty regarding driver experience on treacherous mountain passes. 

Hahakar was founded by a team of Nepali tech innovators, tourism logistics veterans, and mobility enthusiasts with a singular vision: **to digitize Nepal's vehicle fleet into a unified, transparent, and instantly bookable platform where every price is clear in Nepalese Rupees (NPR) and every driver and vehicle is 100% verified.**

Today, Hahakar connects thousands of domestic travelers, international tourists, trekking teams, and corporate organizations directly with verified vehicles, eliminating unnecessary middlemen and empowering local operators.

---

### Our Mission & Vision

#### 🎯 Our Mission
To deliver seamless, safe, and transparent ground travel across Nepal by connecting passengers with verified local vehicles and professional drivers through instant digital booking, upfront NPR pricing, and zero hidden fees.

#### 🏔️ Our Vision
To establish Nepal's most trusted, sustainable, and technologically advanced mobility network—empowering Nepali vehicle owners with dignified daily livelihoods while giving travelers the confidence to explore every corner of the Himalayas.

---

### The 5 Pillars of Hahakar Nepal

```
   ┌─────────────────────────────────────────────────────────────────┐
   │                    THE HAHAKAR GUARANTEE                        │
   ├───────────────────┬───────────────────┬─────────────────────────┤
   │ 1. 100% VERIFIED  │ 2. TRANSPARENT    │ 3. 4WD MOUNTAIN         │
   │    Bluebooks &    │    NPR Rates &    │    Offroad & Highway    │
   │    Driver Licenses│    Zero Counter   │    Engineered Fleets    │
   │                   │    Surprises      │                         │
   ├───────────────────┴───────────────────┴─────────────────────────┤
   │ 4. DIRECT LOCAL PARTNER PAYOUTS (85%+ TRIP SPLIT TO OPERATORS)  │
   │ 5. ZERO PREPAYMENT HASSLE (INSTANT DIGITAL VOUCHER + PAY ON HUB)│
   └─────────────────────────────────────────────────────────────────┘
```

1. **Rigorous Bluebook & Compliance Verification:**
   Every vehicle in our catalog undergoes document screening—including Government Bluebook (*Billbook*) validity, annual road tax clearance, fitness certificates, and commercial route permits. Driver partners must pass strict license validation (Category 'B' minimum) and background checks.

2. **Transparent Rates in Nepalese Rupees (NPR):**
   We eliminate predatory tourist pricing and broker commissions. All vehicle offers clearly state exact daily rates, mileage terms, and optional driver outstation allowances upfront in NPR.

3. **Engineered for Nepal's Topography:**
   Nepal's diverse terrain requires specialized vehicles. We categorize fleets specifically for their operational suitability—from high-clearance 4WDs (Mahindra Scorpio 4WD, Toyota Hilux) for Mustang and mountain highways, to high-roof tourist HiAce vans for group pilgrimages and city hatchbacks for urban efficiency.

4. **Promoting Green Himalayan Travel (EV Fleets):**
   We actively champion environmental conservation by expanding direct booking for Electric Vehicles (EVs like BYD Atto 3 and Tata Nexon EV) along highway charging corridors connecting Kathmandu, Chitwan, and Pokhara.

5. **Empowering Local Driver Livelihoods:**
   Unlike exploitative aggregator models, Hahakar ensures our driver partners and fleet owners retain **85%+ of trip revenues**, fostering local economic resilience across all 7 provinces of Nepal.

---

### Operating Hubs & Islandwide Coverage
Hahakar operates vehicle pickup and drop-off stations across Nepal's premier travel and commercial gateways:

- 🏛️ **Kathmandu Valley (KTM):** Tribhuvan International Airport Gate, Thamel Tourist Center, Lalitpur Patan, Kalanki Bus Terminal, and Bhaktapur.
- 🌊 **Pokhara (PKR):** Pokhara International Airport, Lakeside North/South, Damside, and Sarangkot Gateway.
- 🦏 **Chitwan (BHR):** Bharatpur Airport, Sauraha Wildlife Safari Hub, and Narayangarh Commercial Center.
- 🪷 **Lumbini & Butwal (BWA):** Gautam Buddha International Airport, Sacred Maya Devi Garden, and Butwal Trade Hub.
- 🌾 **Eastern Hubs (BIR):** Biratnagar Domestic Airport, Itahari Junction, Dharan, and Ilam Tea Estate Gateways.
- 🏔️ **Western & Karnali Hubs (KEP):** Nepalgunj Airport, Bardia National Park, Kohalpur, and Surkhet Gateway to Rara Lake.

---

### Our Fleet Spectrum

| Vehicle Category | Featured Models | Seating / Luggage | Ideal Nepal Routes |
| :--- | :--- | :--- | :--- |
| **4WD Mountain SUV** | Mahindra Scorpio 4WD S11, Toyota Hilux | 7-8 Seats • 4-5 Bags | Muktinath, Upper Mustang, Manang, B.P. Highway |
| **Tourist Commuter Van** | Toyota HiAce Commuter, Force Traveller | 14-16 Seats • 10+ Bags | Family Pilgrimage, Trekking Transfers, Corporate |
| **City Economy** | Suzuki Swift, Hyundai Grand i10 | 5 Seats • 2 Bags | Kathmandu Valley, Lalitpur, Pokhara City Tours |
| **Compact Family SUV** | Hyundai Creta, Kia Seltos | 5 Seats • 3 Bags | Prithvi Highway, Chitwan, Bandipur, Lumbini |
| **Electric SUV (EV)** | BYD Atto 3 EV, Tata Nexon EV | 5 Seats • 3 Bags | Zero-emission Kathmandu-Pokhara Highway Drives |
| **VIP Luxury Expedition** | Toyota Land Cruiser Prado TX | 7 Seats • 5 Bags | Executive Delegations, VIP Safaris, Luxury Tours |

---

### Safety & Traveler Support Commitment
Your peace of mind is paramount. Every Hahakar reservation includes:
- **Instant Digital Voucher:** Sent instantly to your email and WhatsApp upon booking.
- **24/7 Roadside & Breakdown Support:** Immediate mechanical assistance and replacement dispatch.
- **Free Cancellation Window:** Flexible cancellation up to 24–48 hours prior to vehicle handover.
- **Dedicated Nepal Travel Desk:** Local support staff fluent in Nepali, English, and Hindi.

---

### Headquarters & Official Inquiries

- 🏢 **Corporate Headquarters:** Hahakar Nepal Pvt. Ltd., Thamel Tourist Center, Kathmandu, Bagmati Province, Nepal
- 📧 **General Inquiries:** info@hahakar.com / support@hahakar.com
- 🤝 **Partner & Fleet Onboarding:** partner@hahakar.com
- 📞 **24/7 Hotline:** +977 9801424252 / +977 9801-HAHAKAR
- 💬 **WhatsApp Desk:** +977 9801424252",
                'meta_title' => 'About Hahakar Nepal - Nepal\'s #1 Vehicle Rental & Mobility Network',
                'meta_description' => 'Discover the story, mission, verified fleet ecosystem, and 24/7 support standards behind Hahakar Nepal car rental comparison and direct booking platform.',
            ],
            [
                'title' => 'Terms & Conditions',
                'slug' => 'terms',
                'content' => "## Terms & Conditions of Rental & Mobility Services\n\n*Effective Date: September 2026 | Governing Jurisdiction: Federal Democratic Republic of Nepal*\n\nWelcome to **Hahakar Nepal** (\"Hahakar\", \"we\", \"us\", or \"platform\"). These Terms and Conditions govern your access to and use of the Hahakar vehicle rental comparison search engine, direct reservation platform, partner onboarding services, and all related mobile or web interfaces (collectively, the \"Services\").\n\nBy making a reservation, searching vehicle offers, listing a fleet, or using any part of the Hahakar platform, you (\"Customer\", \"Renter\", \"Partner\", or \"User\") agree to be legally bound by these Terms and Conditions.\n\n---\n\n### 1. Scope of Platform Services & Service Models\nHahakar operates as Nepal's dedicated vehicle rental metasearch aggregator and direct reservation network. We facilitate connections between verified vehicle owners, licensed commercial fleet operators (\"Partners / Suppliers\"), and travelers (\"Customers\").\n\nWe offer two distinct rental modalities across Nepal:\n1. **With Verified Driver (Chauffeur Service):** The vehicle is operated exclusively by an experienced, verified professional driver licensed for Nepal's highways and mountain routes.\n2. **Self-Drive Rental:** The vehicle is leased directly to the customer for self-navigation subject to mandatory document screening, physical inspection, and refundable security deposit.\n\n---\n\n### 2. Eligibility & Document Verification\nTo ensure road safety and compliance with Nepal Department of Transport Management (DoTM) regulations, renters must meet the following criteria:\n\n#### A. Self-Drive Eligibility:\n- **Minimum Age:** Renter must be at least **21 years old** (25 years old for luxury SUVs and commercial passenger vans).\n- **Driving License:** Must possess a valid, original physical Driving License (held for a minimum of 1 year).\n  - *Nepali Nationals:* Valid Category 'B' (Light Four-Wheeler) Driving License.\n  - *Foreign Nationals & Tourists:* Valid International Driving Permit (IDP) accompanied by their native country driver's license.\n- **Identity Proof:** Valid Government Citizenship Certificate (Nagarikta), National Identity Card (NID), or original Passport with valid Nepal Entry Visa.\n- **Local Contact & Stay Details:** Hotel address, local phone number, and emergency contact in Nepal.\n\n#### B. Driver-Assisted (Chauffeur) Bookings:\n- No driving license is required from the customer. The primary contact must provide valid government-issued photo ID (Citizenship, NID, or Passport) and an active Nepali or international phone number (with WhatsApp).\n\n---\n\n### 3. Pricing, Inclusions, and Payment Protocol\nTransparency is our core standard. All rates displayed on Hahakar are quoted in **Nepalese Rupees (NPR / Rs.)**.\n\n#### A. Standard Inclusions:\n- Vehicle hire charges for the agreed duration and daily mileage limits.\n- Mandatory vehicle road taxes, fitness permits, and standard third-party insurance coverage.\n- For chauffeur bookings: Professional driver remuneration.\n\n#### B. Out-of-Pocket / Variable Inclusions:\nUnless explicitly indicated in your booking confirmation:\n- **Fuel (Petrol / Diesel / EV Charging):** Handed over with a noted fuel level and must be returned with the equivalent fuel level (e.g., Full-to-Full policy).\n- **Toll Fees & Parking:** Local municipality road tolls (e.g. Mugling-Narayanghat highway, Pokhara lakeside entry, airport parking) are payable directly by the renter.\n- **Driver Outstation Allowance (Bhatta):** For multi-day overnight trips outside base operational cities (Kathmandu or Pokhara), standard driver night accommodation and meal allowance (Rs. 1,000–1,500/night) applies if not provided by customer.\n\n#### C. Payment Methods:\n- **Cash on Pickup:** Pay the full rental balance directly to the verified driver or station counter upon vehicle delivery.\n- **Digital Wallets & QR:** Fonepay QR, eSewa, and Khalti payments are accepted directly upon handover.\n- **Zero Prepayment:** No credit card holds or advance processing fees are required to secure standard reservations on Hahakar.\n\n---\n\n### 4. Security Deposit & Refund (Self-Drive)\n- For self-drive bookings, a refundable security deposit (ranging from **Rs. 2,000 to Rs. 20,000**, depending on vehicle segment) is collected upon vehicle handover.\n- **Deposit Refund:** Refunded immediately upon return of the vehicle following a 10-minute return inspection confirming no structural damages, missing accessories, or unpaid traffic violations.\n\n---\n\n### 5. Vehicle Use Guidelines & Geographic Restrictions\nTo protect passengers and vehicles across Nepal's diverse topography, renters agree to the following rules:\n\n1. **Mountain & Off-Road Terrains:**\n   - High-clearance **4WD vehicles** (Mahindra Scorpio 4WD, Toyota Hilux, Toyota Prado) are strictly required for trips to Mustang, Manang, Upper Mustang, Rara Lake, and remote Himalayan off-road trails.\n   - Low-clearance hatchbacks and sedans are restricted to paved highway routes and valley roads.\n2. **Prohibited Activities:**\n   - Operating the vehicle under the influence of alcohol, drugs, or narcotics (**Zero Tolerance** under Nepal Traffic Police rules).\n   - Sub-leasing, renting out to third parties, or permitting unauthorized drivers to operate the vehicle.\n   - Transporting illegal substances, contraband, wildlife products, or unlicensed commercial cargo.\n   - Off-road rallying, street racing, towing, or overloading passengers beyond the vehicle's official seat capacity.\n3. **Cross-Border Restrictions:**\n   - Vehicles may **NOT** cross international borders into India, China, or Tibet under any circumstances without prior written consular authorization and government customs clearance (Bhansar).\n\n---\n\n### 6. Cancellation, Modifications & Natural Calamity Exceptions\n- **Free Cancellation:** You may cancel your reservation with **zero penalty** up to **24 to 48 hours** prior to your scheduled pickup time.\n- **Late Cancellation / No-Show:** If you cancel less than 12 hours before pickup or fail to arrive at the designated pickup hub without prior notification, your reservation will be released.\n- **Monsoon & Landslide Exceptions:** In cases of severe weather disruptions, road closures (such as Prithvi Highway or B.P. Highway blockages), landslides, or flight cancellations, Hahakar will reschedule your vehicle booking or cancel without any penalty fees.\n\n---\n\n### 7. Breakdowns, Roadside Assistance & Accidents\n1. **24/7 Breakdown Assistance:** In the rare event of mechanical failure or breakdown, our dispatch team will coordinate local roadside support or provide an equivalent replacement vehicle.\n2. **Accident Reporting Protocol:**\n   - In case of any collision or accident, the renter must immediately contact Hahakar Support Care and the nearest Nepal Traffic Police outpost (Dial 103 or 100).\n   - An official Police Spot Report (FIR / Sarjameen) is mandatory for insurance processing.\n3. **Renter Liability (Self-Drive):** The renter is responsible for damages caused by willful negligence, driving off authorized roads, or tire/rim punctures resulting from improper driving.\n\n---\n\n### 8. Driver Partner Standards & Rest Hours\nFor driver-assisted trips:\n- Standard daily driving hours are capped at **8 to 10 hours** in daytime conditions to prevent driver fatigue and uphold maximum mountain road safety.\n- Drivers reserve the right to decline travel on visibly hazardous roads deemed unsafe due to active rockfalls, flash floods, or extreme blizzard conditions.\n\n---\n\n### 9. Privacy & Personal Data\nPersonal data (name, contact number, ID copies) collected during booking is strictly utilized for identity validation, trip dispatch, and regulatory compliance. We do not sell or monetize personal information. Refer to our [Privacy Policy](/privacy) for comprehensive information.\n\n---\n\n### 10. Governing Law & Dispute Resolution\nThese Terms and Conditions shall be governed by and construed in accordance with the laws of the **Federal Democratic Republic of Nepal**, including the *Motor Vehicles and Transport Management Act 2049 (1993)* and the *National Civil Code 2074*. Any disputes arising from the use of Hahakar services shall be subject to the exclusive jurisdiction of the competent courts of Kathmandu, Nepal.\n\n---\n\n### 11. Customer Support & Legal Inquiries\nFor any questions regarding these Terms or assistance with an active booking:\n- 🏢 **Hahakar Nepal Operations Hub:** Thamel Tourist Center, Kathmandu, Bagmati Province, Nepal\n- 📧 **Legal & Compliance:** support@hahakar.com\n- 📞 **24/7 Roadside & Booking Helpdesk:** +977 9801424252 / +977 9801-HAHAKAR\n- 💬 **WhatsApp Direct Desk:** +977 9801424252",
                'meta_title' => 'Terms of Service | Hahakar Nepal',
                'meta_description' => 'Comprehensive terms, conditions, rental rules, eligibility, deposit guidelines, and insurance policies for Hahakar Nepal car rental and chauffeur services.',
            ],
            [
                'title' => 'Privacy Policy & Data Protection',
                'slug' => 'privacy',
                'content' => "## Privacy Policy & Data Protection Standards\n\n*Effective Date: September 2026 | Governing Law: Individual Privacy Act 2075 (Nepal)*\n\nAt **Hahakar Nepal** (\"Hahakar\", \"we\", \"us\", or \"our\"), we hold your privacy, digital security, and personal data confidentiality in the highest regard. This Privacy Policy details how we collect, handle, store, share, and protect your personal information when you access our metasearch comparison tools, book vehicles directly, register as a driver partner, or interact with our mobile and web applications.\n\nBy utilizing our services, you consent to the information handling practices described in this Privacy Policy.\n\n---\n\n### 1. Legal Framework & Regulatory Compliance\nOur data processing practices strictly comply with the **Individual Privacy Act, 2075 (2018)** and the **Electronic Transactions Act, 2063 (2006)** of the Federal Democratic Republic of Nepal, alongside recognized international data protection benchmarks.\n\n---\n\n### 2. Information We Collect\nTo facilitate safe, verified, and transparent vehicle bookings across Nepal, we collect information across three main categories:\n\n#### A. Information You Directly Provide to Us:\n- **Customer Contact Information:** Full Name, Email Address, Mobile Phone Number (including WhatsApp number for real-time mountain driver coordination).\n- **Trip & Itinerary Specifics:** Pickup and Drop-off locations (e.g. Kathmandu KTM Airport, Pokhara Lakeside), rental dates and times, flight arrival numbers, and special route notes.\n- **Self-Drive Identity & Compliance Verification:** When booking self-drive vehicles, we collect scanned copies or photographs of your physical Driving License (Category 'B' or International Driving Permit), Nepali Citizenship Certificate (*Nagarikta*), National Identity Card (NID), or Foreign Passport with valid Nepal Entry Visa.\n- **Driver Partner & Fleet Operator Submissions:** Full legal name, permanent and current address, driving license credentials, Vehicle Registration Bluebook (*Billbook*) pages, vehicle photos, route permits, and bank/eSewa payout account details.\n\n#### B. Automatically Collected Technical Data:\n- Device and connection metadata including IP address, browser type and version, operating system, language preferences, and referring URLs.\n- Usage telemetry such as vehicle search parameters, filter selections, page interaction times, and error diagnostic logs.\n\n#### C. Location Information:\n- If location permissions are enabled on your device, we may receive approximate location data to suggest the nearest pickup hubs (e.g., Tribhuvan International Airport vs. Thamel Hub).\n\n---\n\n### 3. How We Use Your Personal Information\nWe use collected information solely for legitimate operational and compliance purposes:\n1. **Booking Coordination & Dispatch:** Communicating your trip itinerary to your assigned verified driver or fleet operator for seamless pickup.\n2. **Compliance & Risk Prevention:** Verifying the authenticity of driving licenses and identity documents to safeguard passengers and vehicles against fraud or unauthorized vehicle operation.\n3. **Transactional Notifications:** Sending instant digital booking vouchers, SMS arrival alerts, itinerary modifications, and WhatsApp support messages.\n4. **Price Drop Alerts:** Delivering opt-in price tracking notifications when rates drop on your monitored Nepal routes.\n5. **Customer Support:** Resolving roadside queries, lost-and-found items, trip extensions, and billing clarifications.\n6. **Legal & Law Enforcement Obligations:** Fulfilling mandatory reporting requirements under Nepal Traffic Police, Tourist Police, or Department of Transport Management (DoTM) directives.\n\n---\n\n### 4. Data Sharing & Third-Party Disclosure Policy\n**We do NOT sell, lease, or monetize your personal data to advertisers or third-party marketing brokers.**\n\nYour data is shared exclusively in the following controlled scenarios:\n- **Assigned Drivers & Fleet Operators:** We share only operational details (Customer Name, Phone Number, and Pickup Location) necessary to execute your trip.\n- **Essential Infrastructure Providers:** Cloud server hosts, transactional SMS gateways, and secure email delivery providers operating under strict confidentiality agreements.\n- **Legal & Regulatory Authorities:** When compelled by a lawful court subpoena, police warrant, or statutory safety investigation in Nepal.\n\n---\n\n### 5. Document Security & Data Retention\n- **Transmission Encryption:** All data exchanged between your browser and our platform is protected using modern Transport Layer Security (TLS 1.3 / HTTPS) with 256-bit encryption.\n- **Restricted Access:** Sensitive verification documents (licenses, citizenship cards, bluebooks) are stored in secure, access-controlled repositories accessible only by authorized compliance personnel.\n- **Retention Lifespan:** Document scans provided for self-drive verification are securely archived only for the duration mandated by local accounting and transport regulations, after which they are irreversibly anonymized or purged.\n\n---\n\n### 6. Cookies and Tracking Technologies\nWe use essential and functional cookies to:\n- Maintain your active search state and vehicle filter preferences.\n- Keep you securely logged into your Customer or Partner dashboard.\n- Analyze aggregated website traffic patterns to improve platform speed and usability.\n\nYou can manage or disable non-essential cookies through your browser preferences. For detailed guidance, please review our [Cookie Policy](/cookies).\n\n---\n\n### 7. Your Rights and Data Choices\nUnder Nepal's privacy regulations, you have full control over your personal information:\n- **Right to Access:** You may request a summary of the personal data we hold about you.\n- **Right to Rectification:** You may request correction of any inaccurate or outdated information in your profile.\n- **Right to Erasure:** You may request the deletion of your account and personal records, subject to statutory tax and regulatory retention requirements.\n- **Right to Opt-Out:** You can unsubscribe from promotional announcements or price drop alerts at any time via the one-click unsubscribe link or by contacting support.\n\n---\n\n### 8. Protection of Minors\nHahakar does not knowingly collect or solicit personal information from individuals under the age of 18. If we discover that personal information of a minor has been collected without parental consent, we will promptly delete that data.\n\n---\n\n### 9. Policy Updates & Notifications\nWe may update this Privacy Policy periodically to reflect evolving legal standards or platform features. Material changes will be highlighted with an updated effective date on this page and notified via a site announcement banner.\n\n---\n\n### 10. Privacy Desk & Grievance Contact\nIf you have any questions, concerns, or requests regarding your personal data or this policy, please contact our dedicated Privacy Officer:\n\n- 🏢 **Data Controller:** Hahakar Nepal Pvt. Ltd.\n- 📍 **Address:** Thamel Tourist Center, Kathmandu, Bagmati Province, Nepal\n- 📧 **Privacy & Grievance Email:** privacy@hahakar.com / support@hahakar.com\n- 📞 **Data Protection Helpdesk:** +977 9801424252\n- 💬 **WhatsApp Support:** +977 9801424252",
                'meta_title' => 'Privacy Policy & Data Rights | Hahakar Nepal',
                'meta_description' => 'Learn how Hahakar Nepal protects your personal data, verification documents, and privacy under the Nepal Individual Privacy Act 2075.',
            ],
            [
                'title' => 'Cookie Policy',
                'slug' => 'cookies',
                'content' => "## Cookie Policy\n\nWe use essential cookies to maintain your search session, booking progress, and preferred pickup location preferences.",
                'meta_title' => 'Cookie Policy | Hahakar Nepal',
                'meta_description' => 'Learn how Hahakar uses cookies for site navigation and session preferences.',
            ],
            [
                'title' => 'Affiliate & Operator Disclosure',
                'slug' => 'affiliate-disclosure',
                'content' => "## Operator & Transparency Disclosure\n\nHahakar is an independent car rental metasearch engine and direct reservation network in Nepal. We compare vehicle prices from licensed rental providers and verified independent fleet operators across Nepal. When you book directly or click through to partner offers, we maintain 100% price transparency with guaranteed zero markup on displayed NPR rates.",
                'meta_title' => 'Affiliate & Operator Disclosure | Hahakar Nepal',
                'meta_description' => 'Transparency and operator disclosure policy for Hahakar Nepal car rental aggregator.',
            ],
        ];

        foreach ($pages as $p) {
            Page::updateOrCreate(
                ['slug' => $p['slug']],
                array_merge($p, ['is_published' => true, 'published_at' => now()])
            );
        }

        // 2. FAQs
        $faqs = [
            [
                'category' => 'General',
                'question' => 'What types of vehicles are available for rent in Nepal?',
                'answer' => 'We offer vehicles suited for all Nepal terrain: 4WD Mountain SUVs (Mahindra Scorpio, Toyota Hilux), Tourist Vans (Toyota HiAce 14-seater, Force Traveller), Compact SUVs (Hyundai Creta), City Hatchbacks (Suzuki Swift, Grand i10), Electric Vehicles (BYD Atto 3 EV), and Premium 4WDs (Toyota Prado).',
                'sort_order' => 1,
            ],
            [
                'category' => 'Booking & Chauffeur',
                'question' => 'Can I hire a car with an experienced local driver?',
                'answer' => 'Yes! You can choose "With Driver (Chauffeur)" for any vehicle. Our verified drivers are experienced with Nepal mountain highways, Prithvi Highway turns, and high-altitude routes like Mustang and Pokhara.',
                'sort_order' => 2,
            ],
            [
                'category' => 'Self-Drive',
                'question' => 'What documents are required for Self-Drive car rental in Nepal?',
                'answer' => 'For self-drive rentals, you need a valid physical Nepali Driving License or International Driving Permit (IDP), plus a copy of your Citizenship card or Passport.',
                'sort_order' => 3,
            ],
            [
                'category' => 'Pricing & Payment',
                'question' => 'How and when do I pay for my vehicle booking?',
                'answer' => 'You can book directly with zero prepayment! Pay in Nepalese Rupees (NPR) via Cash or digital wallet (eSewa / QR) directly upon vehicle handover or pickup.',
                'sort_order' => 4,
            ],
            [
                'category' => 'Cancellation',
                'question' => 'What is the cancellation policy?',
                'answer' => 'Most bookings on Hahakar feature free cancellation up to 24-48 hours before your scheduled pickup time.',
                'sort_order' => 5,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                array_merge($faq, ['is_published' => true])
            );
        }

        // 3. Settings
        $settings = [
            ['key' => 'site_name', 'value' => 'Hahakar Nepal', 'group' => 'general', 'description' => 'Public brand name'],
            ['key' => 'support_email', 'value' => 'support@hahakar.com', 'group' => 'contact', 'description' => 'Main customer support inbox'],
            ['key' => 'default_currency', 'value' => 'NPR', 'group' => 'general', 'description' => 'Default platform currency'],
            ['key' => 'rate_per_km_petrol', 'value' => '250', 'group' => 'distance_pricing', 'description' => 'Default rate per km for Petrol vehicles (Rs./km)'],
            ['key' => 'rate_per_km_diesel', 'value' => '250', 'group' => 'distance_pricing', 'description' => 'Default rate per km for Diesel vehicles (Rs./km)'],
            ['key' => 'rate_per_km_electric', 'value' => '70', 'group' => 'distance_pricing', 'description' => 'Default rate per km for Electric EVs (Rs./km)'],
            ['key' => 'rate_per_km_hybrid', 'value' => '160', 'group' => 'distance_pricing', 'description' => 'Default rate per km for Hybrid vehicles (Rs./km)'],
            ['key' => 'alert_cooldown_hours', 'value' => '12', 'group' => 'alerts', 'description' => 'Minimum hours between alert notifications for same criteria'],
            ['key' => 'ranking_weight_price', 'value' => '0.45', 'group' => 'ranking', 'description' => 'Ranking weight for total price'],
            ['key' => 'ranking_weight_terms', 'value' => '0.15', 'group' => 'ranking', 'description' => 'Ranking weight for terms completeness'],
            ['key' => 'ranking_weight_supplier', 'value' => '0.15', 'group' => 'ranking', 'description' => 'Ranking weight for supplier star rating'],
            ['key' => 'ranking_weight_cancellation', 'value' => '0.10', 'group' => 'ranking', 'description' => 'Ranking weight for free cancellation'],
            ['key' => 'ranking_weight_freshness', 'value' => '0.10', 'group' => 'ranking', 'description' => 'Ranking weight for data freshness'],
            ['key' => 'ranking_weight_commercial', 'value' => '0.05', 'group' => 'ranking', 'description' => 'Ranking weight for commercial boost (capped)'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
