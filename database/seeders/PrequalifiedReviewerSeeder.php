<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PrequalifiedReviewer;

class PrequalifiedReviewerSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            /*
            ==========================================================
            SUBTHEME 17
            Agribusiness, Financing, Policy, Adoption, and Socio-Economic Dimensions
            ==========================================================
            */

            [
                'sub_theme_id' => 17, 
                'name' => 'Scolastica Wambua', 
                'title' => 'Dr.', 
                'institution' => 'KALRO Headquarters', 
                'phone_email' => '0727457659 scolastica.wambua@kalro.org', 
                'area_of_specialization' => 'Agribusiness Management', 
            ], 
            [ 
                'sub_theme_id' => 17, 
                'name' => 'Mathai Ndungu',
                'title' => 'Mr.', 
                'institution' => 'KALRO Oljoro Orok', 
                'phone_email' =>'0722296541 ndungu.mathai@kalro.org', 
                'area_of_specialization' => 'Agribusiness Management', 
            ], 
            [ 
                'sub_theme_id' => 17, 
                'name' => 'Simon P.W. Omondi',
                'title' => 'Dr.', 
                'institution' => 'KALRO Mtwapa', 
                'phone_email' => '0717444923 simon.omondi@kalro.org', 
                'area_of_specialization' => 'Agribusiness Management', 
            ], 
            [ 
                'sub_theme_id' => 17, 
                'name' => 'James Maina Minai',
                'title' => 'Mr.', 
                'institution' => 'KALRO Ruiru', 
                'phone_email' => '0722641667 James.Minai@kalro.org', 
                'area_of_specialization' => 'Agribusiness Management & Trade', 
            ], 
            [ 
                'sub_theme_id' => 17, 
                'name' => 'Mumina Guyo Shibia', 
                'title' => 'Dr.', 
                'institution' => 'KALRO Headquarters',
                'phone_email' => '0727718755 Mumina.Shibia@kalro.org', 
                'area_of_specialization' => 'Agricultural and Applied Economics', 
            ], 
            [ 
                'sub_theme_id' => 17,
                'name' => 'Charles Bett', 
                'title' => 'Mr.', 
                'institution' => 'KALRO ABIRI Perkerra', 
                'phone_email' => '0713241421 Charles.Bett@kalro.org',
                'area_of_specialization' => 'Agricultural Economics', 
            ], 
            [ 
                'sub_theme_id' => 17,
                'name' => 'Stella N. Makokha', 
                'title' => 'Dr.', 
                'institution' => 'KALRO BioRI Kabete', 
                'phone_email' => '0721558965 Stella.Makokha@kalro.org',
                'area_of_specialization' => 'Agricultural Economics', 
            ], 
            [ 
                'sub_theme_id' => 17,
                'name' => 'Tabby Karanja', 
                'title' => 'Ms.', 
                'institution' => 'KALRO FCRC Kabete', 
                'phone_email' => '0722490978 Tabby.Karanja@kalro.org',
                'area_of_specialization' => 'Agricultural Economics', 
            ], 
            [ 
                'sub_theme_id' => 17,
                'name' => 'Stella Jane Matere', 
                'title' => 'Dr.', 
                'institution' => 'KALRO FCRC Muguga', 
                'phone_email' => '0722704640 Stella.Matere@kalro.org', 
                'area_of_specialization' => 'Agricultural Economics',
            ], 
            [ 
                'sub_theme_id' => 17, 
                'name' => 'Alice Murage', 
                'title' => 'Dr.',
                'institution' => 'KALRO Headquarters', 
                'phone_email' => '0720891539 Alice.Murage@kalro.org', 
                'area_of_specialization' => 'Agricultural Economics',
            ], 
            [ 
                'sub_theme_id' => 17, 
                'name' => 'Fredah Maina', 
                'title' => 'Dr.',
                'institution' => 'KALRO Headquarters', 
                'phone_email' => '0721291808 Fredah.Maina@kalro.org', 
                'area_of_specialization' => 'Agricultural Economics',
            ], 
            [ 
                'sub_theme_id' => 17, 
                'name' => 'Wellington Mulinge',
                'title' => 'Dr.', 
                'institution' => 'KALRO Headquarters', 
                'phone_email' => '0720788921 Wellington.Mulinge@kalro.org', 
                'area_of_specialization' => 'Agricultural Economics', 
            ], 
            [ 
                'sub_theme_id' => 17, 
                'name' => 'Faith Njeri Nguthi', 
                'title' => 'Ms.', 
                'institution' => 'KALRO ICRC Sericulture', 
                'phone_email' => '0722807291 Faith.Nguthi@kalro.org',
                'area_of_specialization' => 'Agricultural Economics', 
            ], 
            [ 
                'sub_theme_id' => 17,
                'name' => 'Rosemary Emongor', 
                'title' => 'Dr.', 
                'institution' => 'KALRO Kabete', 
                'phone_email' => '0725836635 Rosemary.Emongor@kalro.org',
                'area_of_specialization' => 'Agricultural Economics', 
            ], 
            [ 
                'sub_theme_id' => 17,
                'name' => 'Martins Odendo', 
                'title' => 'Dr.', 
                'institution' => 'KALRO NRI Kakamega', 
                'phone_email' => '0713 413062 Martins.Odendo@kalro.org',
                'area_of_specialization' => 'Agricultural Economics', 
            ], 
            [ 
                'sub_theme_id' => 17,
                'name' => 'John M. Ndungu', 
                'title' => 'Dr.', 
                'institution' => 'KALRO HRI Kandara', 
                'phone_email' => '0722780300 john.ndungu@kalro.org', 
                'area_of_specialization' => 'Agricultural Economics', 
            ],
            [ 
                'sub_theme_id' => 17, 
                'name' => 'Paul Kiprop Kiprono', 
                'title' => 'Dr.', 
                'institution' => 'KALRO HRI Kandara', 
                'phone_email' => '0722806729 Paul.Kiprono@kalro.org', 
                'area_of_specialization' => 'Agricultural economics', 
            ], 
            [ 
                'sub_theme_id' => 17, 
                'name' => 'John R M Wambua',
                'title' => 'Dr.', 
                'institution' => 'KALRO AMRI Katumani', 
                'phone_email' => '0705018619 John.Wambua@kalro.org', 
                'area_of_specialization' => 'Agricultural Economics', 
            ], 
            [ 
                'sub_theme_id' => 17, 
                'name' => 'Juma Magogo', 
                'title' => 'Dr.', 
                'institution' => 'KALRO Mariakani', 
                'phone_email' => 'juma.magogo@kalro.org', 
                'area_of_specialization' => 'Agricultural Economics',
            ], 
            [ 
                'sub_theme_id' => 17, 
                'name' => 'Kadenge Lewa', 
                'title' => 'Mr.',
                'institution' => 'KALRO Mtwapa', 
                'phone_email' => '0722284640 Lewa.Kadenge@kalro.org', 
                'area_of_specialization' => 'Agricultural economics',
            ], 
            [ 
                'sub_theme_id' => 17, 
                'name' => 'Anne Gichangi', 
                'title' => 'Dr.',
                'institution' => 'KALRO FCRI Njoro', 
                'phone_email' => '0722333485 Anne.gichangi@kalro.org', 
                'area_of_specialization' => 'Agricultural Economics',
            ], 
            [ 
                'sub_theme_id' => 17, 
                'name' => 'Nancy M Nganga', 
                'title' => 'Ms.',
                'institution' => 'KALRO Tigoni', 
                'phone_email' => '0721462439 Nancy.Nganga@kalro.org', 
                'area_of_specialization' => 'Agricultural Economics',
            ], 
            [ 
                'sub_theme_id' => 17, 
                'name' => 'Paul Odongo Ayiemba', 
                'title' => 'Mr.', 
                'institution' => 'KALRO TRI, Kericho', 
                'phone_email' => '0720017174 Paul.Odongo@kalro.org', 
                'area_of_specialization' => 'Agricultural Economics', 
            ], 
            [ 
                'sub_theme_id' => 17, 
                'name' => 'Judith K Chemuliti',
                'title' => 'Ms.', 
                'institution' => 'KALRO VSRI Muguga', 
                'phone_email' => '0721603455 Judith.Chemuliti@kalro.org', 
                'area_of_specialization' => 'Agricultural Economics', 
            ], 
            [ 
                'sub_theme_id' => 17, 
                'name' => 'David Otieno', 
                'title' => 'Dr.', 
                'institution' => 'University of Nairobi',
                'phone_email' => '0721660756 ayiekodav@gmail.com', 
                'area_of_specialization' => 'Agricultural Economics', 
            ], 
            [ 
                'sub_theme_id' => 17, 
                'name' => 'Paswel Marenya Phiri', 
                'title' => 'Dr.', 
                'institution' => 'CIMMYT',
                'phone_email' => '0714884011 p.marenya@cgiar.org', 
                'area_of_specialization' => 'Agricultural Economics', 
            ], 
            [ 
                'sub_theme_id' => 17, 
                'name' => 'Narmandakh Davaatseren', 
                'title' => 'Dr.', 
                'institution' => 'CIMMYT',
                'phone_email' => '0719610530 D.NARMANDAKH@cgiar.org', 
                'area_of_specialization' => 'Agricultural Economics', 
            ], 
            [ 
                'sub_theme_id' => 17, 
                'name' => 'George Owuro', 
                'title' => 'Prof.', 
                'institution' => 'University',
                'phone_email' => '0722831634; gowuor2012@gmail.com', 
                'area_of_specialization' => 'Agricultural Economics', 
            ], 
            [ 
                'sub_theme_id' => 17, 
                'name' => 'Caroline Thuo', 
                'title' => 'Ms.', 
                'institution' => 'KALRO HRI Tigoni',
                'phone_email' => '0721233167 Caroline.Thuo@kalro.org', 
                'area_of_specialization' => 'Agricultural Extension', 
            ], 
            [ 
                'sub_theme_id' => 17, 
                'name' => 'Kennedy Wanjala', 
                'title' => 'Dr.', 
                'institution' => 'KALRO BioRI Muguga', 
                'phone_email' => '0722620788 Kennedy.Barasa@kalro.org',
                'area_of_specialization' => 'Anthropology and sociology', 
            ], 
            [ 
                'sub_theme_id' => 17, 
                'name' => 'Beth Wangari Ndungu', 
                'title' => 'Dr.', 
                'institution' => 'KALRO HRI Thika', 
                'phone_email' => '0722295272 Beth.ndungu@kalro.org',
                'area_of_specialization' => 'Anthropology/Gender', 
            ],
            [ 
                'sub_theme_id' => 17,
                'name' => 'Anastasia W. Kagunyu', 
                'title' => 'Dr.', 
                'institution' => 'KALRO BioRI Kabete', 
                'phone_email' => '0723770295 Anastasia.Kagunyu@kalro.org', 
                'area_of_specialization' => 'Anthropology/Gender/Sociology', 
            ], 
            [ 
                'sub_theme_id' => 17, 
                'name' => 'John Manyeki', 
                'title' => 'Dr.', 
                'institution' => 'KALRO ARLRI Kiboko',
                'phone_email' => '0769383853 manyekijk@gmail.com', 
                'area_of_specialization' => 'Economics', 
            ], 
            [ 
                'sub_theme_id' => 17, 
                'name' => 'Purity Kinya Kaburu',
                'title' => 'Ms.', 
                'institution' => 'KALRO VSRI Muguga', 
                'phone_email' => '0722432506 Purity.kaburu@kalro.org', 
                'area_of_specialization' => 'Economics/Agribusiness', 
            ], 
            [ 
                'sub_theme_id' => 17, 
                'name' => 'Stephen Irungu Kariuki', 
                'title' => 'Mr.', 
                'institution' => 'KALRO Seeds Kandara', 
                'phone_email' => '0725162374 Stephen.Irungu@kalro.org',
                'area_of_specialization' => 'Entrepreneurship', 
            ], 
            [ 
                'sub_theme_id' => 17,
                'name' => 'Morgan Mutoko', 
                'title' => 'Dr.', 
                'institution' => 'KALRO FCRI Muguga', 
                'phone_email' => '0732677892 morgan.mutoko@kalro.org',
                'area_of_specialization' => 'Environmental Economics', 
            ], 
            [ 
                'sub_theme_id' => 17, 
                'name' => 'Jessica Ndubi Maithekia', 
                'title' => 'Dr.', 
                'institution' => 'KALRO Headquarters', 
                'phone_email' => '0721368417 jessicandubi@gmail.com', 
                'area_of_specialization' => 'Gender',
            ], 
            [
                'sub_theme_id' => 17, 
                'name' => 'Elias Gitonga Thuranira', 
                'title' => 'Mr.', 
                'institution' => 'KALRO BioRI Kabete', 
                'phone_email' => '0723606204 Elias.Thuranira@kalro.org',
                'area_of_specialization' => 'Statistics and Research Methods', 
            ], 
            [
                'sub_theme_id' => 8, 
                'name' => 'Desterio Nyamongo', 
                'title' => 'Dr.',
                'institution' => 'KALRO GeRRI Muguga', 
                'phone_email' => '0725234249 dnyamongo@yahoo.co.uk', 
                'area_of_specialization' => 'Geneticist/ science/biodiversity', 
            ], 
            [ 
                'sub_theme_id' => 8, 
                'name' => 'Peterson Wambugu',
                'title' => 'Dr.', 
                'institution' => 'KALRO GeRRI Muguga', 
                'phone_email' => '0722563141 pwambuguw@gmail.com', 
                'area_of_specialization' => 'Seed science/Biodiversity conservation', 
            ], 
            [ 
                'sub_theme_id' => 9, 
                'name' => 'Simon Kuria', 
                'title' => 'Dr.', 
                'institution' => 'KALRO ARLRI Kiboko',
                'phone_email' => '0722289697 kuriasg@gmail.com', 
                'area_of_specialization' => 'Animal Nutrition', 
            ], 
            [ 
                'sub_theme_id' => 9, 
                'name' => 'Washington Otieno', 
                'title' => 'Dr.', 
                'institution' => 'FAO', 
                'phone_email' => '0722427097 Wotieno2000@gmail.com', 
                'area_of_specialization' => 'Dryland management/ Forage research', 
            ], 
            [ 'sub_theme_id' => 9, 'name' => 'Bosco
                Kidake', 'title' => 'Dr.', 'institution' => 'KALRO ARLRI', 'phone_email'
                => '0723723403; bkkidake@gmail.com', 'area_of_specialization' => 'Dryland
                management/ Forage research', ], [ 'sub_theme_id' => 9, 'name' =>
                'Solomon Mwendia', 'title' => 'Dr.', 'institution' => 'CIAT',
                'phone_email' => '0722674299; S.Mwendia@cgiar.org', 'area_of_specialization' =>
                'Forage agronomy', ], [ 'sub_theme_id' => 9, 'name' => 'David Miano
                Mwangi', 'title' => 'Dr.', 'institution' => 'KALRO Headquarters',
                'phone_email' => '0727781127; davidmianomwangi@gmail.com',
                'area_of_specialization' => 'Forage agronomy', ], [ 'sub_theme_id' => 9, 'name'
                => 'Richard K. A. Kyuma, OGW', 'title' => 'Dr.', 'institution' =>
                'MoALD, Directorate of Livestock Production', 'phone_email' =>
                '0721552964 livestock@kilimo.go.ke', 'area_of_specialization' => 'Livestock
                production systems, animal husbandry, technology transfer in livestock
                value chains TT in livestock; scaling', ], [ 'sub_theme_id' => 9, 'name'
                => 'David Kimani Mbugua', 'title' => 'Mr.', 'institution' => 'KALRO DRI,
                Naiavasha', 'phone_email' => '0722898811 David.Mbugua@kalro.org',
                'area_of_specialization' => 'Animal Science', ], [ 'sub_theme_id' => 9, 'name'
                => 'Oliver Wasonga', 'title' => 'Prof.', 'institution' => 'University of
                Nairobi, Kabete, LARMAT', 'phone_email' => '0722 258765;
                oliverwasonga@uonbi.ac.ke', 'area_of_specialization' => 'Range ecology/ Dryland
                Management', ], [ 'sub_theme_id' => 9, 'name' => 'Oscar Koech', 'title'
                => 'Dr.', 'institution' => 'University of Nairobi, Kabete, LARMAT',
                'phone_email' => '0725513044; oscarkip@uonbi.ac.ke', 'area_of_specialization' =>
                'Range management & livestock nutrition', ], [ 'sub_theme_id' => 9,
                'name' => 'Stephen Mureithi', 'title' => 'Dr.', 'institution' =>
                'University of Nairobi Kabete, LARMAT', 'phone_email' => '0720401486
                stemureithi@uonbi.ac.ke', 'area_of_specialization' => 'Rangeland Ecology/ land
                and water management', ], [ 'sub_theme_id' => 9, 'name' => 'Bernard
                Korir', 'title' => 'Dr.', 'institution' => 'KALRO ARLRI Kiboko',
                'phone_email' => '0726149436 Bernard.Korir@kalro.org', 'area_of_specialization'
                => 'Animal nutrition and feed science', ], [ 'sub_theme_id' => 11,
                'name' => 'Elise Schieck', 'title' => 'Dr.', 'institution' => 'ILRI',
                'phone_email' => '0792745077 e.schieck@cgiar.org', 'area_of_specialization' =>
                'Vaccine Development and Molecular Biology', ], [ 'sub_theme_id' => 11,
                'name' => 'John Mugambi', 'title' => 'Dr.', 'institution' =>
                'Freelance', 'phone_email' => '0721433783, jommugambi@gmail.com',
                'area_of_specialization' => 'Veterinary Science', ], [ 'sub_theme_id' => 11,
                'name' => 'John Kagira', 'title' => 'Dr.', 'institution' => 'JKUAT',
                'phone_email' => '0726731970, jkagira@jkuat.ac.ke', 'area_of_specialization' =>
                'Veterinary Science', ], [ 'sub_theme_id' => 11, 'name' => 'Joseph
                Nginyi', 'title' => 'Dr.', 'institution' => 'KALRO VSRI Muguga',
                'phone_email' => '0722859314, Joseph.Nginyi@kalro.org', 'area_of_specialization'
                => 'Veterinary Science', ], [ 'sub_theme_id' => 11, 'name' => 'Monicah
                Maichomo', 'title' => 'Dr.', 'institution' => 'KALRO VSRI Muguga',
                'phone_email' => '0720710457, Monicah.Maichomo@kalro.org',
                'area_of_specialization' => 'Veterinary science', ], [ 'sub_theme_id' => 11,
                'name' => 'Jerono kiptanui', 'title' => 'Dr.', 'institution' => 'Moi
                University', 'phone_email' => '0722659186; drjerono16@gmail.com',
                'area_of_specialization' => 'Veterinary Science', ], [ 'sub_theme_id' => 11,
                'name' => 'Joseph Omega', 'title' => 'Dr.', 'institution' => 'University
                of Eldoret', 'phone_email' => '0722461135; joseph.omega@uoeld.ac.ke',
                'area_of_specialization' => 'Veterinary Science', ], [ 'sub_theme_id' => 11,
                'name' => 'Daniel Muasya', 'title' => 'Dr.', 'institution' =>
                'University of Nairobi', 'phone_email' => '0726842915,
                 daniel.wambua@uonbi.ac.ke', 'area_of_specialization' => 'Veterinary Science',
                ], [ 'sub_theme_id' => 11, 'name' => 'Peter Kimeli', 'title' => 'Dr.',
                'institution' => 'University of Nairobi', 'phone_email' => '0726241137,
                kimeli08@uonbi.ac.ke', 'area_of_specialization' => 'Veterinary Science', ], [
                'sub_theme_id' => 12, 'name' => 'Richard Kimitei', 'title' => 'Mr.',
                'institution' => 'KALRO GeRRI', 'phone_email' => '0720779934;
                Richard.kimitei@kalro.org', 'area_of_specialization' => 'Agricultural Entomology
                (Apiculture & beneficial insects)-', ], [ 'sub_theme_id' => 12, 'name'
                => 'Judith Mbau', 'title' => 'Dr.', 'institution' => 'University of
                Nairobi', 'phone_email' => '0722212100; jmbau@uonbi.ac.ke',
                'area_of_specialization' => 'Apiculture', ], [ 'sub_theme_id' => 12, 'name' =>
                'Muo Kasina', 'title' => 'Dr.', 'institution' => 'KALRO Kabete',
                'phone_email' => '0723375984; Muo.kasina@kalro.org, jkasina@yahoo.com,
                kasina.j@gmail.com', 'area_of_specialization' => 'Agricultural Entomology', ], [
                'sub_theme_id' => 13, 'name' => 'Harrison Lutta', 'title' => 'Dr.',
                'institution' => 'KALRO', 'phone_email' => '0722296494
                Harrison.Lutta@kalro.org', 'area_of_specialization' => 'Animal Biotechnology',
                ], [ 'sub_theme_id' => 13, 'name' => 'Willis Adero', 'title' => 'Dr.',
                'institution' => 'KALRO', 'phone_email' => '0721703342
                Willis.Adero@kalro.org', 'area_of_specialization' => 'Animal Biotechnology', ],
                [ 'sub_theme_id' => 13, 'name' => 'Winnie Okeyo', 'title' => 'Dr.',
                'institution' => 'KALRO', 'phone_email' => '0723850454
                Winnie.Okeyo@kalro.org', 'area_of_specialization' => 'Animal Biotechnology', ],
                [ 'sub_theme_id' => 13, 'name' => 'Edward Nguu', 'title' => 'Prof.',
                'institution' => 'University of Nairobi', 'phone_email' => '0722-598467
                ednguu@uonbi.ac.ke', 'area_of_specialization' => 'Applied biotechnology and
                industrial microbiology', ], [ 'sub_theme_id' => 13, 'name' => 'Steven
                Nyanjom', 'title' => 'Dr.', 'institution' => 'Jomo Kenyatta University
                of Agriculture and Technology', 'phone_email' => '0721593457
                snyanjom@jkuat.ac.ke', 'area_of_specialization' => 'Biotechnology and genetic
                engineering', ], [ 'sub_theme_id' => 13, 'name' => 'Peris Amwai',
                'title' => 'Dr.', 'institution' => 'Technical University of Kenya',
                'phone_email' => '0721293219 peris.amwayi@tukenya.ac.ke',
                'area_of_specialization' => 'Biotechnology and microbiology', ], [
                'sub_theme_id' => 13, 'name' => 'Wilton Mwema', 'title' => 'Prof.',
                'institution' => 'Pwani University', 'phone_email' => '0722723950
                w.mwema@pu.ac.ke', 'area_of_specialization' => 'Microbiology and Biotechnology',
                ], [ 'sub_theme_id' => 13, 'name' => 'Felix Rotich', 'title' => 'Dr.',
                'institution' => 'Embu University', 'phone_email' => '0721453658;
                kimichir@gmail.com rotich.felix@embuni.ac.ke', 'area_of_specialization' =>
                'Molecular Biology and Biotechnology', ], [ 'sub_theme_id' => 13, 'name'
                => 'Gerald Juma', 'title' => 'Dr.', 'institution' => 'Uiversity of
                Nairobi', 'phone_email' => '0704252505 gjuma@uonbi.ac.ke',
                'area_of_specialization' => 'Molecular Biology and Biotechnology', ], [
                'sub_theme_id' => 13, 'name' => 'Paul Kuria', 'title' => 'Dr.',
                'institution' => 'KALRO', 'phone_email' => '0786255608
                Paul.Kuria@kalro.org', 'area_of_specialization' => 'Plant biotechnology', ], [
                'sub_theme_id' => 13, 'name' => 'Bramwel Wanjala', 'title' => 'Dr.',
                'institution' => 'KALRO BIORI-Kabete', 'phone_email' => '0722408246;
                Bramwel.Wanjala@kalro.org', 'area_of_specialization' => 'Plant biotechnology',
                ], [ 'sub_theme_id' => 13, 'name' => 'James Karanja', 'title' => 'Dr.',
                'institution' => 'KALRO Njoro', 'phone_email' => '0721811561
                jakakah79@gmail.com', 'area_of_specialization' => 'Plant Biotechnology and
                biotechnology', ], [ 'sub_theme_id' => 13, 'name' => 'Leena Tripathi',
                'title' => 'Prof.', 'institution' => 'IITA', 'phone_email' =>
                '0731089399 L.TRIPATHI@cgiar.org', 'area_of_specialization' => 'Plant
                Biotechnology and Genome Editing', ], [ 'sub_theme_id' => 13, 'name' =>
                'Douglas Miano', 'title' => 'Prof.', 'institution' => 'University of
                Nairobi', 'phone_email' => '0780919259; dmiano@uonbi.ac.ke',
                'area_of_specialization' => 'Plant Pathology (Virology) and Biotechnology', ], [
                'sub_theme_id' => 7, 'name' => 'Agnes Yobterik', 'title' => 'Ms.',
                'institution' => 'KALRO Headquarters', 'phone_email' => '0790999086
                Agnes.Yobterik@kalro.org', 'area_of_specialization' => 'Climate adaptation and
                mitigation strategies, land restoration interventions, and resilience
                frameworks', ], [ 'sub_theme_id' => 7, 'name' => 'Kennedy Were', 'title'
                => 'Dr.', 'institution' => 'KALRO Kabete', 'phone_email' => '0717429539
                Kennedy.Were@kalro.org', 'area_of_specialization' => 'Climate adaptation and
                mitigation strategies, land restoration interventions, and resilience
                frameworks', ], [ 'sub_theme_id' => 7, 'name' => 'Bulle Dabasso',
                'title' => 'Dr.', 'institution' => 'KALRO Garissa', 'phone_email' =>
                '0727429105 Bulle.Dabasso@Kalro.org', 'area_of_specialization' => 'Climate
                adaptation and mitigation strategies, land restoration interventions,
                and resilience frameworks', ], [ 'sub_theme_id' => 1, 'name' => 'Amana
                Juma Mzee', 'title' => 'Dr.', 'institution' => 'Pwani University',
                'phone_email' => '0723459949 amana_juma@yahoo.com', 'area_of_specialization' =>
                'Biochemistry', ], [ 'sub_theme_id' => 1, 'name' => 'Paul Kimurto',
                'title' => 'Prof.', 'institution' => 'Egerton University', 'phone_email'
                => '0725309162 kimurtopk@gmail.com', 'area_of_specialization' => 'Crop
                Physiology', ], [ 'sub_theme_id' => 1, 'name' => 'Ruth Musila', 'title'
                => 'Dr', 'institution' => 'KALRO Mwea', 'phone_email' => '0723917819,
                ruthmusila@gmail.com;ruth.musila@kalro.org', 'area_of_specialization' => 'Plant
                Breeder', ], [ 'sub_theme_id' => 1, 'name' => 'Terresa Okiyo', 'title'
                => 'Dr.', 'institution' => 'KALRO Kibos', 'phone_email' => '0721860013,
                tokiyo2006@yahoo.com;teresa.okiyo@kalro.org', 'area_of_specialization' =>
                'Breeder', ], [ 'sub_theme_id' => 1, 'name' => 'Murega Mwimali', 'title'
                => 'Dr.', 'institution' => 'KALRO AMRI', 'phone_email' => '0722915500,
                mwimali@gmail.com;murenga.mwimali@kalro.org', 'area_of_specialization' =>
                'Breeder', ], [ 'sub_theme_id' => 1, 'name' => 'Susan Wanderi', 'title'
                => 'Dr.', 'institution' => 'KALRO Embu', 'phone_email' => '0722363905,
                wanderi_susan@yahoo.com;susan.wanderi@kalro.org', 'area_of_specialization' =>
                'Breeder', ], [ 'sub_theme_id' => 1, 'name' => 'Vincent Woyengo',
                'title' => 'Dr.', 'institution' => 'KALRO Kakamega', 'phone_email' =>
                '0729981023, vincent.woyengo@kalro.org;vwoyengo@gmail.com',
                'area_of_specialization' => 'Roots and Tuber Breeder', ], [ 'sub_theme_id' => 1,
                'name' => 'Nancy Karimi', 'title' => 'Dr.', 'institution' => 'KALRO
                HQs', 'phone_email' => '0710527757, nancy.karimi@kalro.org',
                'area_of_specialization' => 'Crop improvement and seed systems', ], [
                'sub_theme_id' => 1, 'name' => 'Philip Leley', 'title' => 'Dr.',
                'institution' => 'KALRO Kitale', 'phone_email' => '0711369535,
                pkenda64@gmail.com;pkleley@yahoo.co.uk;phillip.leley@kalro.org',
                'area_of_specialization' => 'Breeder', ], [ 'sub_theme_id' => 1, 'name' =>
                'Godwin Macharia', 'title' => 'Dr.', 'institution' => 'KALRO Molo',
                'phone_email' => '0723765846, Godwin.Macharia@kalro.org',
                'area_of_specialization' => 'Breeder', ], [ 'sub_theme_id' => 1, 'name' =>
                'Joseph Njuguna Kori', 'title' => 'Dr.', 'institution' => 'KALRO HRI',
                'phone_email' => '0722365752, joseph,njuguna@kalro.org',
                'area_of_specialization' => 'Mango expert', ], [ 'sub_theme_id' => 1, 'name' =>
                'Susan Otieno', 'title' => 'Dr', 'institution' => 'KALRO Tigoni',
                'phone_email' => '0721561058, otienosu@gmail.com;', 'area_of_specialization' =>
                'Breeder', ], [ 'sub_theme_id' => 1, 'name' => 'Moses Nyonges', 'title'
                => 'Dr.', 'institution' => 'KALRO Tigoni', 'phone_email' => '0710840670,
                moses.nyomgesa@kalro.org', 'area_of_specialization' => 'Potato Seed System
                expert', ], [ 'sub_theme_id' => 1, 'name' => 'Charity Gathambiri',
                'title' => 'Ms', 'institution' => 'KALRO HRI', 'phone_email' =>
                '0722400675, charity.gathambiri@kalro.org;charitymberia246@gmail.com',
                'area_of_specialization' => 'Post harvest and Value addition', ], [
                'sub_theme_id' => 1, 'name' => 'Christine Kasichana', 'title' => 'Dr',
                'institution' => 'KALRO Matuga', 'phone_email' => '0701102969,
                christistinekasichana321@gmail.com', 'area_of_specialization' => 'Value addition
                expert', ], [ 'sub_theme_id' => 1, 'name' => 'Francis Muniu', 'title' =>
                'Mr', 'institution' => 'KALRO Mtwapa', 'phone_email' => '0722887283,
                francis.muniu@kalro.org;fkmuniu@gmail.com', 'area_of_specialization' => 'Cashew
                nut expert', ], [ 'sub_theme_id' => 1, 'name' => 'Mwalimu Menza',
                'title' => 'Mr', 'institution' => 'KALRO Mtwapa', 'phone_email' =>
                '0723623309, mwalimu11@gmail.com;mwalimu.menza@kalro.org',
                'area_of_specialization' => 'Coconut expert', ], [ 'sub_theme_id' => 1, 'name'
                => 'Everlyne Kirwa', 'title' => 'Dr.', 'institution' => 'KALRO HQs',
                'phone_email' => '0721454799,
                everlyne.kirwa@kalro.org;eckirwa@gmail.com', 'area_of_specialization' => 'Forage
                breeder', ], [ 'sub_theme_id' => 1, 'name' => 'Noel Makete', 'title' =>
                'Dr.', 'institution' => 'KALRO Sericulture', 'phone_email' =>
                '0712793886, noel.makete@kalro.org', 'area_of_specialization' =>
                'Agronomist/value addition', ], [ 'sub_theme_id' => 1, 'name' =>
                'Francis Wayua', 'title' => 'Dr.', 'institution' => 'KALRO DRI,
                Naiavasha', 'phone_email' => '0710629683, francis.wayua @kalro.org',
                'area_of_specialization' => 'Post harvest and Value addition', ], [
                'sub_theme_id' => 1, 'name' => 'James Ndambuki', 'title' => 'Mr',
                'institution' => 'KALRO Muguga', 'phone_email' =>
                '0798640534,james.ndambuki@kalro.org', 'area_of_specialization' => 'Food Science
                and Nutrition', ], [ 'sub_theme_id' => 1, 'name' => 'Chrispus Oduori',
                'title' => 'Dr.', 'institution' => 'KALRO Kibos', 'phone_email' =>
                '0723770895, chrisoduori@yahoo.com;chrispus.oduori@kalro.org',
                'area_of_specialization' => 'Breeder', ], [ 'sub_theme_id' => 1, 'name' =>
                'Rachael Kisilu', 'title' => 'Ms', 'institution' => 'KALRO AMRI',
                'phone_email' => '0722970221, rkkisilu@gmail.com;
                rachael.kisilu@kalro.org', 'area_of_specialization' => 'Breeder', ], [
                'sub_theme_id' => 1, 'name' => 'Samson Kamunya', 'title' => 'Dr.',
                'institution' => 'KALRO Kabete', 'phone_email' => '0722282741,
                samson.kamunya@yahoo.com;samson.kamunya@kalro.org', 'area_of_specialization' =>
                'Breeder', ], [ 'sub_theme_id' => 1, 'name' => 'Thomas Kwambai', 'title'
                => 'Dr.', 'institution' => 'KALRO Kitale', 'phone_email' => '0722468614,
                thomas.kwambai2586@gmail.com;thomas.kwambai@kalro.org', 'area_of_specialization'
                => 'Seed Specialist', ], [ 'sub_theme_id' => 1, 'name' => 'Margaret
                Makelo', 'title' => 'Dr.', 'institution' => 'KALRO HQs', 'phone_email'
                => '0715757501, margaret.makelo@kalro.org;', 'area_of_specialization' =>
                'Breeder', ], [ 'sub_theme_id' => 1, 'name' => 'Dorcus Chepkesis
                Gemenet', 'title' => 'Dr.', 'institution' => 'Cimmyt', 'phone_email' =>
                '0757439459, d.gemenet@cgiar.org', 'area_of_specialization' =>
                'Breeder/Biotechnology', ], [ 'sub_theme_id' => 1, 'name' => 'Lilian
                Gichuru', 'title' => 'Dr.', 'institution' => 'Cymmit', 'phone_email' =>
                '0780611022,lilian.gichuru@gmail.com', 'area_of_specialization' => 'Seed
                science/ Breeder', ], [ 'sub_theme_id' => 1, 'name' => 'Elijah Gichuru',
                'title' => 'Dr.', 'institution' => 'CRI-Ruiru', 'phone_email' =>
                '0723152655, ekgichuru@gmail.com;', 'area_of_specialization' => 'Breeder', ], [
                'sub_theme_id' => 1, 'name' => 'James Gimase', 'title' => 'Dr.',
                'institution' => 'CRI-Ruiru', 'phone_email' => '0726979459,
                jgimase@gmail.com', 'area_of_specialization' => 'Breeder', ], [ 'sub_theme_id'
                => 1, 'name' => 'Jane Cheserek', 'title' => 'Dr.', 'institution' =>
                'CRI-Ruiru', 'phone_email' => '0720336651, chesekjerono@gmail.com',
                'area_of_specialization' => 'Breeder', ], [ 'sub_theme_id' => 1, 'name' =>
                'Daniel Omari (MSc)', 'title' => 'Mr', 'institution' => 'CRI-Ruiru',
                'phone_email' => '0717906932, dnlomari85@gmail.com', 'area_of_specialization' =>
                'Breeder', ], [ 'sub_theme_id' => 1, 'name' => 'John Mwangi (Pursuing
                PhD )', 'title' => 'Mr', 'institution' => 'CRI-Ruiru', 'phone_email' =>
                '0721634049, imwangijohn@yahoo.com', 'area_of_specialization' => 'Breeder', ], [
                'sub_theme_id' => 1, 'name' => 'Linet N Nasiroli', 'title' => 'Ms',
                'institution' => 'KALRO Alupe', 'phone_email' => '0722363905,
                lynet.nasiroli@gmail.com;', 'area_of_specialization' =>
                'Breeder/biotechnologist', ], [ 'sub_theme_id' => 1, 'name' => 'Joseph I
                Kamau', 'title' => 'Mr', 'institution' => 'Gerri', 'phone_email' =>
                '0716175421, irerikamau@yahoo.com', 'area_of_specialization' => 'Breeder/
                conservation expert', ], [ 'sub_theme_id' => 1, 'name' => 'Donald
                Njaruhi', 'title' => 'Dr.', 'institution' => 'KALRO kabete',
                'phone_email' => '0798447012, donald.njarui@kalro.org;',
                'area_of_specialization' => 'Forage breeder', ], [ 'sub_theme_id' => 1, 'name'
                => 'Richard Chalo', 'title' => 'Dr', 'institution' => 'KALRO TRI,
                Kericho', 'phone_email' => '0722371176, rmchalo@gmail.com',
                'area_of_specialization' => 'Breeder', ], [ 'sub_theme_id' => 1, 'name' => 'Tony
                Maritim', 'title' => 'Dr', 'institution' => 'KALRO TRI, Kericho',
                'phone_email' => '0722572132, tmaritim@gmail.com', 'area_of_specialization' =>
                'Breeder', ], [ 'sub_theme_id' => 1, 'name' => 'Robert Korir (MSc)',
                'title' => 'Mr', 'institution' => 'KALRO TRI, Kericho', 'phone_email' =>
                '0724442793, rkkorir@yahoo.com', 'area_of_specialization' => 'Breeder', ], [
                'sub_theme_id' => 1, 'name' => 'Antony J Nyaga', 'title' => 'Mr',
                'institution' => 'KALRO seeds', 'phone_email' => '0722400696,
                tony.njue.nyaga@gmail.com;antony.nyaga@kalro.org', 'area_of_specialization' =>
                'seed systems expert', ], [ 'sub_theme_id' => 1, 'name' => 'Bornface
                Juma Awalla', 'title' => 'Dr', 'institution' => 'KALRO Kitale',
                'phone_email' => '0720473633, jumawalla@yahoo.com', 'area_of_specialization' =>
                'Breeder', ], [ 'sub_theme_id' => 1, 'name' => 'Theresia L Munga',
                'title' => 'Dr.', 'institution' => 'KALRO Msabaha', 'phone_email' =>
                '0723293109, tlmalamala@yahoo.com;theresia.munga@kalro.org',
                'area_of_specialization' => 'nan', ], [ 'sub_theme_id' => 1, 'name' => 'John
                Munji Kimani', 'title' => 'Dr.', 'institution' => 'KALRO Mtwapa',
                'phone_email' => '0729853035, John.Kimani@kalro.org', 'area_of_specialization'
                => 'nan', ], [ 'sub_theme_id' => 1, 'name' => 'Henry Okwaro (MSc)',
                'title' => 'Mr', 'institution' => 'KALRO Njoro', 'phone_email' =>
                '0725100359, henryokwaro@yahoo.co.uk; Henry.okwaro@kalro.org',
                'area_of_specialization' => 'Roots and Tuber Breeder', ], [ 'sub_theme_id' => 1,
                'name' => 'Zennah C Kosgey', 'title' => 'Ms', 'institution' => 'KALRO
                Njoro', 'phone_email' => '0710917211, Zennah.Kosgey@kalro.org',
                'area_of_specialization' => 'Biotechnology/breeding', ], [ 'sub_theme_id' => 1,
                'name' => 'Beatrice N. Tenge', 'title' => 'Ms', 'institution' => 'KALRO
                Njoro', 'phone_email' => '0722650858, beatricetenge@yahoo.com;',
                'area_of_specialization' => 'Biotechnology/breeding', ], [ 'sub_theme_id' => 1,
                'name' => 'John Ndungu', 'title' => 'Dr.', 'institution' => 'KALRO
                Njoro', 'phone_email' => '0724732721, john.ndungu@kalro.org',
                'area_of_specialization' => 'Food Biochemistry/seed systems', ], [
                'sub_theme_id' => 1, 'name' => 'Stella M Katini', 'title' => 'Ms',
                'institution' => 'KALRO Mtwapa', 'phone_email' => '0722940339,
                stellakatini@gmail.com;stellah.katini@kalro.org', 'area_of_specialization' =>
                'Seedling propagation expert', ], [ 'sub_theme_id' => 1, 'name' =>
                'Eliezah M Kamau', 'title' => 'Dr.', 'institution' => 'KALRO HRI
                Kandara', 'phone_email' => '0721395254, eliezahngware@yahoo.com;',
                'area_of_specialization' => 'Breeder', ], [ 'sub_theme_id' => 1, 'name' =>
                'Abdelbagi Ismail', 'title' => 'Dr.', 'institution' => 'IRRI Africa
                Rep.', 'phone_email' => '0748812506 a.ismail@irri.org', 'area_of_specialization'
                => 'Crop science, abiotic stress tolerance, climate‑smart rice
                technologies', ], [ 'sub_theme_id' => 1, 'name' => 'Stephen Sikolia',
                'title' => 'Dr.', 'institution' => 'Maseno University', 'phone_email' =>
                '0726946708 fsikolia@maseno.ac.ke', 'area_of_specialization' => 'Genetics and
                Molecular Biology', ], [ 'sub_theme_id' => 1, 'name' => 'Janet Kimunye',
                'title' => 'Dr.', 'institution' => 'CIMMYT', 'phone_email' =>
                '0721695180; J.Kimunye@cgiar.org', 'area_of_specialization' => 'Molecular
                Biology and Genetics', ], [ 'sub_theme_id' => 1, 'name' => 'Henry
                Kariithi', 'title' => 'Dr.', 'institution' => 'KALRO', 'phone_email' =>
                '0702117653 henry.kariithi@kalro.org', 'area_of_specialization' => 'Molecular
                biology and genetics', ], [ 'sub_theme_id' => 1, 'name' => 'Hussein
                Abkallo', 'title' => 'Dr.', 'institution' => 'ILRI', 'phone_email' =>
                '0721732731H.Abkallo@cgiar.org', 'area_of_specialization' => 'Molecular Biology
                and Genome Editing', ], [ 'sub_theme_id' => 1, 'name' => 'Esther
                Kanduma', 'title' => 'Dr.', 'institution' => 'University of Nairobi',
                'phone_email' => '0722674542 ekanduma@uonbi.ac.ke', 'area_of_specialization' =>
                'Molecular Biology and Parasitology', ], [ 'sub_theme_id' => 1, 'name'
                => 'Runo Steven', 'title' => 'Prof.', 'institution' => 'Kenyatta
                University', 'phone_email' => '0727346496 runo.steve@ku.ac.ke',
                'area_of_specialization' => 'Molecular Biology, Genetic engineering, Genome
                editing', ], [ 'sub_theme_id' => 1, 'name' => 'Jane Mbugua', 'title' =>
                'Dr.', 'institution' => 'KALRO GeRRI', 'phone_email' => '0720593123;
                Jane.Mbugua@kalro.org; jayney480@yahoo.com', 'area_of_specialization' => 'Plant
                breeding', ], [ 'sub_theme_id' => 1, 'name' => 'Felister Mbute', 'title'
                => 'Dr.', 'institution' => 'University of Nairobi', 'phone_email' =>
                '0723048386 fnzuve@uonbi.ac.ke', 'area_of_specialization' => 'Plant Breeding',
                ], [ 'sub_theme_id' => 1, 'name' => 'Staline Kibet', 'title' => 'Dr.',
                'institution' => 'UoN_LARMAT', 'phone_email' => '0720785532
                staline@uonbi.ac.ke', 'area_of_specialization' => 'Plant ecology & Taxonomy', ],
                [ 'sub_theme_id' => 14, 'name' => 'Miriam Charimbu', 'title' => 'Dr.',
                'institution' => 'Egerton University', 'phone_email' => '0704245163;
                miriam.charimbu@egerton.ac.ke, charimbu22y@gmail.com', 'area_of_specialization'
                => 'Crop production and protection', ], [ 'sub_theme_id' => 14, 'name'
                => 'George Abong Ooko', 'title' => 'Prof.', 'institution' => 'University
                of Nairobi, Kabete', 'phone_email' => '0700073386
                ooko.george@uonbi.ac.ke', 'area_of_specialization' => 'Food Science and
                Nutrition', ], [ 'sub_theme_id' => 15, 'name' => 'Reuben Ruttoh',
                'title' => 'Mr.', 'institution' => 'KALRO', 'phone_email' => '0723601246
                reuben.ruttoh@kalro.org', 'area_of_specialization' => 'Agricultural
                mechanization, irrigation engineering, biosystems design, Precision
                systems; engineering', ], [ 'sub_theme_id' => 15, 'name' => 'Franklin
                Mwiti', 'title' => 'Dr.', 'institution' => 'University of Eldoret',
                'phone_email' => '0724525000 frankline.mwiti@uoeld.ac.ke',
                'area_of_specialization' => 'Agricultural mechanization, irrigation engineering,
                biosystems design, Precision systems; engineering', ], [ 'sub_theme_id'
                => 15, 'name' => 'Duncan O. Mbuge (Eng.)', 'title' => 'Prof.',
                'institution' => 'University of Nairobi, Environmental & Biosystems
                Engineering', 'phone_email' => '0725949095: dombuge@uonbi.ac.ke',
                'area_of_specialization' => 'Agricultural mechanization, irrigation engineering,
                biosystems design, Precision systems; engineering', ], [ 'sub_theme_id'
                => 4, 'name' => 'James Mutegi', 'title' => 'Dr.', 'institution' =>
                'APNI', 'phone_email' => 'j.mutegi@apni.net/jmutegi56@gmail.com
                0708992994', 'area_of_specialization' => 'Plant Nutrition, Soil Health and
                Conservation Agriculture', ], [ 'sub_theme_id' => 4, 'name' => 'Peter
                Bwire', 'title' => 'Dr.', 'institution' => 'OCP', 'phone_email' =>
                'ps.bwire@ocpafrica.com 0740 034619/0795620317', 'area_of_specialization' =>
                'Plant Nutrition, Soil Health and Conservation Agriculture', ], [
                'sub_theme_id' => 4, 'name' => 'Keziah Magiroi', 'title' => 'Dr.',
                'institution' => 'KALRO ABIRI Perkerra', 'phone_email' => '0722296363
                Keziah.Ndungu@kalro.org', 'area_of_specialization' => 'Plant Nutrition, Soil
                Health and Conservation Agriculture', ], [ 'sub_theme_id' => 4, 'name'
                => 'Mary Koech', 'title' => 'Dr.', 'institution' => 'KALRO FCRI Kitale',
                'phone_email' => 'Mary.Koech@kalro.org', 'area_of_specialization' => 'Plant
                Nutrition, Soil Health and Conservation Agriculture', ], [
                'sub_theme_id' => 4, 'name' => 'David Kamau', 'title' => 'Dr.',
                'institution' => 'KALRO Headquarters', 'phone_email' => '0722658074
                David.Kamau@kalro.org', 'area_of_specialization' => 'Plant Nutrition, Soil
                Health and Conservation Agriculture', ], [ 'sub_theme_id' => 5, 'name'
                => 'Fabian Kaburu', 'title' => 'Eng.', 'institution' => 'KALRO',
                'phone_email' => 'Fabian.Kaburu@kalro.org 0721250133', 'area_of_specialization'
                => 'Water Harvesting, Conservation and Irrigation Systems', ], [
                'sub_theme_id' => 5, 'name' => 'Peterson Njeru', 'title' => 'Dr.',
                'institution' => 'KALRO', 'phone_email' => 'Peterson.Njeru@kalro.org
                0725956963', 'area_of_specialization' => 'Water Harvesting, Conservation and
                Irrigation Systems', ], ];

        foreach ($data as $reviewer) {

            preg_match('/\d{10,}/', $reviewer['phone_email'], $phoneMatch);
            $phone = $phoneMatch[0] ?? null;

            preg_match('/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}/', $reviewer['phone_email'], $emailMatch);
            $email = $emailMatch[0] ?? null;

            if (!$email) {
                continue;
            }

            PrequalifiedReviewer::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $reviewer['name'],
                    'title' => $reviewer['title'],
                    'phone' => $phone,
                    'institution' => $reviewer['institution'],
                    'area_of_specialization' => $reviewer['area_of_specialization'],
                    'sub_theme_id' => $reviewer['sub_theme_id'],
                ]
            );
        }
    }

}
