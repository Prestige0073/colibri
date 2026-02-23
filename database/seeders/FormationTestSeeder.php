<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Formation;
use App\Models\Module;
use App\Models\ModuleContenu;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuestionOption;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FormationTestSeeder extends Seeder
{
    /**
     * Crée une formation de test complète avec :
     * - 1 Formation gratuite (3 modules)
     * - Chaque module : 2-3 contenus (texte, vidéo, pdf)
     * - 1 Quiz par module + 1 Quiz global de formation
     * - Chaque quiz : 3-5 questions (QCM, vrai/faux, choix multiple)
     * - 1 Utilisateur de test pour suivre la formation
     */
    public function run(): void
    {
        // ============================================================
        // 1. CRÉATION DE L'UTILISATEUR DE TEST
        // ============================================================
        $user = User::firstOrCreate(
            ['email' => 'testeur@colibri.test'],
            [
                'name' => 'Testeur Formation',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ]
        );

        $this->command->info("Utilisateur de test créé : testeur@colibri.test / password123");

        // ============================================================
        // 2. CRÉATION DE LA FORMATION
        // ============================================================
        $formation = Formation::create([
            'titre' => 'Introduction à la Littérature Africaine',
            'description' => 'Découvrez les grandes œuvres et les auteurs majeurs de la littérature africaine, des classiques aux contemporains. Cette formation vous guidera à travers les courants littéraires, les thèmes récurrents et les voix qui ont façonné le paysage littéraire du continent.',
            'objectifs' => "- Connaître les grands auteurs de la littérature africaine\n- Comprendre les principaux courants littéraires\n- Analyser les thèmes récurrents dans la littérature africaine\n- Développer un esprit critique littéraire",
            'prix' => 0,
            'est_gratuit' => true,
            'duree' => '6 heures',
            'niveau' => 'debutant',
            'nombre_modules' => 3,
            'active' => true,
            'categorie' => 'Littérature',
            'prerequis' => 'Aucun prérequis. Ouvert à tous les passionnés de lecture.',
            'note_minimale_certification' => 70,
            'inscrits_count' => 0,
        ]);

        $this->command->info("Formation créée : {$formation->titre} (ID: {$formation->id})");

        // ============================================================
        // 3. MODULE 1 : Les Fondateurs
        // ============================================================
        $module1 = Module::create([
            'formation_id' => $formation->id,
            'titre' => 'Les Fondateurs de la Littérature Africaine',
            'description' => 'Découvrez les pionniers qui ont posé les bases de la littérature africaine moderne : Chinua Achebe, Léopold Sédar Senghor, Aimé Césaire et bien d\'autres.',
            'ordre' => 1,
            'duree' => '2 heures',
            'active' => true,
        ]);

        // Contenus du Module 1
        $m1c1 = ModuleContenu::create([
            'module_id' => $module1->id,
            'type' => 'texte',
            'titre' => 'Introduction : Qu\'est-ce que la littérature africaine ?',
            'description' => 'Un tour d\'horizon de la littérature africaine et de ses origines.',
            'contenu' => "La littérature africaine est un vaste ensemble d'œuvres écrites et orales provenant du continent africain et de sa diaspora.\n\nElle puise ses racines dans les traditions orales millénaires : contes, épopées, proverbes et chants qui ont transmis la sagesse, l'histoire et les valeurs des peuples africains de génération en génération.\n\nAvec la colonisation et l'introduction de l'écriture occidentale, une nouvelle forme de littérature a émergé. Des auteurs comme Chinua Achebe avec \"Things Fall Apart\" (1958) ont ouvert la voie à une littérature qui questionne l'identité, la colonisation et la modernité.\n\nLa Négritude, mouvement littéraire et politique fondé par Aimé Césaire, Léopold Sédar Senghor et Léon-Gontran Damas dans les années 1930, a été un tournant majeur. Ce mouvement affirmait la dignité et la richesse culturelle des peuples noirs face au colonialisme.\n\nAujourd'hui, la littérature africaine est diverse, dynamique et reconnue mondialement. Des auteurs comme Chimamanda Ngozi Adichie, Ngugi wa Thiong'o, ou Alain Mabanckou portent les voix du continent sur la scène internationale.",
            'ordre' => 1,
        ]);

        $m1c2 = ModuleContenu::create([
            'module_id' => $module1->id,
            'type' => 'texte',
            'titre' => 'La Négritude : un mouvement fondateur',
            'description' => 'Comprendre le mouvement de la Négritude et son impact.',
            'contenu' => "La Négritude est un mouvement littéraire, culturel et politique né dans les années 1930 à Paris. Ses fondateurs principaux sont :\n\n**Aimé Césaire** (Martinique, 1913-2008)\nPoète et homme politique, il est l'auteur du \"Cahier d'un retour au pays natal\" (1939), œuvre fondatrice du mouvement. Il a inventé le mot \"négritude\" pour désigner l'ensemble des valeurs culturelles du monde noir.\n\n**Léopold Sédar Senghor** (Sénégal, 1906-2001)\nPremier président du Sénégal indépendant et poète reconnu, il a contribué à théoriser la Négritude. Son recueil \"Chants d'ombre\" (1945) célèbre l'Afrique et ses traditions.\n\n**Léon-Gontran Damas** (Guyane, 1912-1978)\nSon recueil \"Pigments\" (1937) est considéré comme la première œuvre de la Négritude. Il y dénonce avec virulence le colonialisme et l'assimilation culturelle.\n\n**Objectifs du mouvement :**\n- Réhabiliter la culture noire face au mépris colonial\n- Affirmer une identité propre\n- Créer une solidarité entre les peuples noirs du monde\n- Utiliser la littérature comme arme de résistance",
            'ordre' => 2,
        ]);

        $m1c3 = ModuleContenu::create([
            'module_id' => $module1->id,
            'type' => 'texte',
            'titre' => 'Chinua Achebe et le roman africain moderne',
            'description' => 'L\'apport de Chinua Achebe à la littérature mondiale.',
            'contenu' => "**Chinua Achebe** (Nigeria, 1930-2013) est considéré comme le père du roman africain moderne.\n\nSon œuvre majeure, \"Things Fall Apart\" (Le monde s'effondre), publiée en 1958, raconte l'histoire d'Okonkwo, un chef Igbo, et la destruction de sa communauté par l'arrivée des missionnaires et des colonisateurs britanniques.\n\n**Pourquoi ce roman est-il si important ?**\n\n1. **Première perspective africaine** : Avant Achebe, l'Afrique était décrite uniquement par des auteurs occidentaux (Conrad, Kipling). Achebe a donné une voix authentique à l'Afrique.\n\n2. **Complexité culturelle** : Le roman montre une société Igbo riche et complexe, loin des stéréotypes primitifs.\n\n3. **Langue et style** : Achebe a choisi d'écrire en anglais tout en intégrant des proverbes et des expressions Igbo, créant un style littéraire unique.\n\n4. **Critique du colonialisme** : Le roman expose les ravages de la colonisation sur les structures sociales traditionnelles.\n\n**Autres œuvres importantes d'Achebe :**\n- \"No Longer at Ease\" (1960)\n- \"Arrow of God\" (1964)\n- \"A Man of the People\" (1966)\n- \"Anthills of the Savannah\" (1987)\n\nAchebe a ouvert la voie à des générations d'écrivains africains et reste une référence incontournable.",
            'ordre' => 3,
        ]);

        // Quiz du Module 1
        $quiz1 = Quiz::create([
            'module_id' => $module1->id,
            'formation_id' => $formation->id,
            'titre' => 'Quiz : Les Fondateurs',
            'description' => 'Testez vos connaissances sur les fondateurs de la littérature africaine.',
            'duree_minutes' => 10,
            'note_passage' => 60,
            'nombre_tentatives' => 3,
            'afficher_reponses' => true,
            'melanger_questions' => false,
            'melanger_options' => false,
            'active' => true,
        ]);

        // Q1 - QCM
        $q1 = QuizQuestion::create([
            'quiz_id' => $quiz1->id,
            'question' => 'Qui est considéré comme le père du roman africain moderne ?',
            'type' => 'qcm',
            'points' => 2,
            'ordre' => 1,
            'explication' => 'Chinua Achebe, avec son roman "Things Fall Apart" (1958), est universellement reconnu comme le père du roman africain moderne.',
        ]);
        QuestionOption::create(['question_id' => $q1->id, 'option_text' => 'Léopold Sédar Senghor', 'is_correct' => false, 'ordre' => 1]);
        QuestionOption::create(['question_id' => $q1->id, 'option_text' => 'Chinua Achebe', 'is_correct' => true, 'ordre' => 2]);
        QuestionOption::create(['question_id' => $q1->id, 'option_text' => 'Ngugi wa Thiong\'o', 'is_correct' => false, 'ordre' => 3]);
        QuestionOption::create(['question_id' => $q1->id, 'option_text' => 'Wole Soyinka', 'is_correct' => false, 'ordre' => 4]);

        // Q2 - Vrai/Faux
        $q2 = QuizQuestion::create([
            'quiz_id' => $quiz1->id,
            'question' => 'Le mouvement de la Négritude a été fondé dans les années 1950.',
            'type' => 'vrai_faux',
            'points' => 1,
            'ordre' => 2,
            'explication' => 'Faux. La Négritude a été fondée dans les années 1930 à Paris par Aimé Césaire, Léopold Sédar Senghor et Léon-Gontran Damas.',
        ]);
        QuestionOption::create(['question_id' => $q2->id, 'option_text' => 'Vrai', 'is_correct' => false, 'ordre' => 1]);
        QuestionOption::create(['question_id' => $q2->id, 'option_text' => 'Faux', 'is_correct' => true, 'ordre' => 2]);

        // Q3 - Choix multiple
        $q3 = QuizQuestion::create([
            'quiz_id' => $quiz1->id,
            'question' => 'Quels sont les fondateurs du mouvement de la Négritude ? (Sélectionnez toutes les bonnes réponses)',
            'type' => 'choix_multiple',
            'points' => 3,
            'ordre' => 3,
            'explication' => 'Les trois fondateurs de la Négritude sont Aimé Césaire (Martinique), Léopold Sédar Senghor (Sénégal) et Léon-Gontran Damas (Guyane).',
        ]);
        QuestionOption::create(['question_id' => $q3->id, 'option_text' => 'Aimé Césaire', 'is_correct' => true, 'ordre' => 1]);
        QuestionOption::create(['question_id' => $q3->id, 'option_text' => 'Chinua Achebe', 'is_correct' => false, 'ordre' => 2]);
        QuestionOption::create(['question_id' => $q3->id, 'option_text' => 'Léopold Sédar Senghor', 'is_correct' => true, 'ordre' => 3]);
        QuestionOption::create(['question_id' => $q3->id, 'option_text' => 'Léon-Gontran Damas', 'is_correct' => true, 'ordre' => 4]);

        $this->command->info("Module 1 créé : {$module1->titre} (3 contenus, 1 quiz avec 3 questions)");

        // ============================================================
        // 4. MODULE 2 : Les Thèmes Majeurs
        // ============================================================
        $module2 = Module::create([
            'formation_id' => $formation->id,
            'titre' => 'Les Thèmes Majeurs de la Littérature Africaine',
            'description' => 'Explorez les thèmes récurrents : colonialisme, identité, tradition vs modernité, exil et diaspora.',
            'ordre' => 2,
            'duree' => '2 heures',
            'active' => true,
        ]);

        // Contenus du Module 2
        $m2c1 = ModuleContenu::create([
            'module_id' => $module2->id,
            'type' => 'texte',
            'titre' => 'Colonialisme et post-colonialisme',
            'description' => 'Comment la littérature africaine aborde le colonialisme.',
            'contenu' => "Le colonialisme est le thème fondateur de la littérature africaine moderne. Il traverse les œuvres de plusieurs générations d'auteurs.\n\n**La dénonciation du colonialisme :**\n- Ferdinand Oyono, \"Une vie de boy\" (1956) : récit satirique de la vie d'un domestique africain chez un colon français\n- Mongo Beti, \"Le pauvre Christ de Bomba\" (1956) : critique de l'évangélisation forcée\n- Sembène Ousmane, \"Les bouts de bois de Dieu\" (1960) : grève des cheminots du Dakar-Niger\n\n**Le post-colonialisme :**\nAprès les indépendances, les auteurs se sont tournés vers les désillusions :\n- Ahmadou Kourouma, \"Les soleils des indépendances\" (1968) : échec des régimes post-coloniaux\n- Ayi Kwei Armah, \"The Beautyful Ones Are Not Yet Born\" (1968) : corruption et désespoir\n\n**L'héritage colonial :**\nDes auteurs contemporains continuent d'explorer cet héritage :\n- Chimamanda Ngozi Adichie explore l'impact de la guerre du Biafra\n- Ngugi wa Thiong'o refuse d'écrire en anglais comme acte de décolonisation",
            'ordre' => 1,
        ]);

        $m2c2 = ModuleContenu::create([
            'module_id' => $module2->id,
            'type' => 'texte',
            'titre' => 'Identité et tradition vs modernité',
            'description' => 'Le tiraillement entre tradition et modernité dans la littérature.',
            'contenu' => "Le conflit entre tradition et modernité est au cœur de nombreuses œuvres africaines.\n\n**Le choc des cultures :**\nChinua Achebe dans \"Things Fall Apart\" montre comment l'arrivée des Européens détruit les structures traditionnelles Igbo. Okonkwo, le héros, ne peut s'adapter à ce nouveau monde.\n\n**La quête d'identité :**\n- Cheikh Hamidou Kane, \"L'aventure ambiguë\" (1961) : Samba Diallo, tiraillé entre l'école coranique et l'école française, incarne le dilemme de toute une génération.\n- Camara Laye, \"L'enfant noir\" (1953) : autobiographie célébrant la culture Malinké face à l'attraction de la modernité occidentale.\n\n**La femme africaine entre deux mondes :**\n- Mariama Bâ, \"Une si longue lettre\" (1979) : une femme sénégalaise confrontée à la polygamie et à l'évolution des mœurs.\n- Buchi Emecheta, \"The Joys of Motherhood\" (1979) : les sacrifices d'une mère nigériane dans un monde en transition.\n\n**La diaspora et le retour :**\n- Alain Mabanckou, \"Verre Cassé\" (2005) : humour et mélancolie d'un Congolais entre deux rives.\n- Taiye Selasi a inventé le terme \"Afropolitain\" pour désigner les Africains cosmopolites.",
            'ordre' => 2,
        ]);

        // Quiz du Module 2
        $quiz2 = Quiz::create([
            'module_id' => $module2->id,
            'formation_id' => $formation->id,
            'titre' => 'Quiz : Les Thèmes Majeurs',
            'description' => 'Testez vos connaissances sur les thèmes de la littérature africaine.',
            'duree_minutes' => 10,
            'note_passage' => 60,
            'nombre_tentatives' => 3,
            'afficher_reponses' => true,
            'melanger_questions' => false,
            'melanger_options' => false,
            'active' => true,
        ]);

        // Q1 - QCM
        $q4 = QuizQuestion::create([
            'quiz_id' => $quiz2->id,
            'question' => 'Quel auteur a écrit "L\'aventure ambiguë" ?',
            'type' => 'qcm',
            'points' => 2,
            'ordre' => 1,
            'explication' => 'Cheikh Hamidou Kane a écrit "L\'aventure ambiguë" en 1961, un roman sur le tiraillement entre l\'éducation traditionnelle et occidentale.',
        ]);
        QuestionOption::create(['question_id' => $q4->id, 'option_text' => 'Camara Laye', 'is_correct' => false, 'ordre' => 1]);
        QuestionOption::create(['question_id' => $q4->id, 'option_text' => 'Cheikh Hamidou Kane', 'is_correct' => true, 'ordre' => 2]);
        QuestionOption::create(['question_id' => $q4->id, 'option_text' => 'Mongo Beti', 'is_correct' => false, 'ordre' => 3]);
        QuestionOption::create(['question_id' => $q4->id, 'option_text' => 'Ferdinand Oyono', 'is_correct' => false, 'ordre' => 4]);

        // Q2 - Vrai/Faux
        $q5 = QuizQuestion::create([
            'quiz_id' => $quiz2->id,
            'question' => '"Une si longue lettre" de Mariama Bâ traite de la condition féminine au Sénégal.',
            'type' => 'vrai_faux',
            'points' => 1,
            'ordre' => 2,
            'explication' => 'Vrai. Ce roman épistolaire de 1979 aborde la polygamie, le deuil et la condition de la femme dans la société sénégalaise.',
        ]);
        QuestionOption::create(['question_id' => $q5->id, 'option_text' => 'Vrai', 'is_correct' => true, 'ordre' => 1]);
        QuestionOption::create(['question_id' => $q5->id, 'option_text' => 'Faux', 'is_correct' => false, 'ordre' => 2]);

        // Q3 - QCM
        $q6 = QuizQuestion::create([
            'quiz_id' => $quiz2->id,
            'question' => 'Quel auteur a refusé d\'écrire en anglais comme acte de décolonisation linguistique ?',
            'type' => 'qcm',
            'points' => 2,
            'ordre' => 3,
            'explication' => 'Ngugi wa Thiong\'o, auteur kényan, a décidé en 1986 de ne plus écrire qu\'en gikuyu, sa langue maternelle, pour décoloniser l\'esprit africain.',
        ]);
        QuestionOption::create(['question_id' => $q6->id, 'option_text' => 'Wole Soyinka', 'is_correct' => false, 'ordre' => 1]);
        QuestionOption::create(['question_id' => $q6->id, 'option_text' => 'Chinua Achebe', 'is_correct' => false, 'ordre' => 2]);
        QuestionOption::create(['question_id' => $q6->id, 'option_text' => 'Ngugi wa Thiong\'o', 'is_correct' => true, 'ordre' => 3]);
        QuestionOption::create(['question_id' => $q6->id, 'option_text' => 'Alain Mabanckou', 'is_correct' => false, 'ordre' => 4]);

        // Q4 - Choix multiple
        $q7 = QuizQuestion::create([
            'quiz_id' => $quiz2->id,
            'question' => 'Quels thèmes sont récurrents dans la littérature africaine ? (Sélectionnez toutes les bonnes réponses)',
            'type' => 'choix_multiple',
            'points' => 2,
            'ordre' => 4,
            'explication' => 'Le colonialisme, la quête d\'identité et le conflit tradition/modernité sont les trois thèmes les plus récurrents dans la littérature africaine.',
        ]);
        QuestionOption::create(['question_id' => $q7->id, 'option_text' => 'Le colonialisme', 'is_correct' => true, 'ordre' => 1]);
        QuestionOption::create(['question_id' => $q7->id, 'option_text' => 'La science-fiction spatiale', 'is_correct' => false, 'ordre' => 2]);
        QuestionOption::create(['question_id' => $q7->id, 'option_text' => 'La quête d\'identité', 'is_correct' => true, 'ordre' => 3]);
        QuestionOption::create(['question_id' => $q7->id, 'option_text' => 'Le conflit tradition vs modernité', 'is_correct' => true, 'ordre' => 4]);

        $this->command->info("Module 2 créé : {$module2->titre} (2 contenus, 1 quiz avec 4 questions)");

        // ============================================================
        // 5. MODULE 3 : La Littérature Contemporaine
        // ============================================================
        $module3 = Module::create([
            'formation_id' => $formation->id,
            'titre' => 'La Littérature Africaine Contemporaine',
            'description' => 'Les voix actuelles de la littérature africaine : Chimamanda Ngozi Adichie, Alain Mabanckou, Mohamed Mbougar Sarr et les nouvelles tendances.',
            'ordre' => 3,
            'duree' => '2 heures',
            'active' => true,
        ]);

        // Contenus du Module 3
        $m3c1 = ModuleContenu::create([
            'module_id' => $module3->id,
            'type' => 'texte',
            'titre' => 'Chimamanda Ngozi Adichie : la voix d\'une génération',
            'description' => 'Portrait de l\'auteure nigériane et de son impact.',
            'contenu' => "**Chimamanda Ngozi Adichie** (Nigeria, née en 1977) est l'une des voix les plus influentes de la littérature contemporaine mondiale.\n\n**Œuvres majeures :**\n\n1. \"Purple Hibiscus\" (L'hibiscus pourpre, 2003)\nSon premier roman raconte l'histoire de Kambili, une adolescente nigériane vivant sous la tyrannie d'un père fanatique religieux. Le roman explore la liberté, la religion et la violence domestique.\n\n2. \"Half of a Yellow Sun\" (L'autre moitié du soleil, 2006)\nCe roman magistral se déroule pendant la guerre du Biafra (1967-1970). Il raconte l'histoire de trois personnages pris dans le conflit et explore les thèmes de l'amour, de la loyauté et de la guerre civile.\n\n3. \"Americanah\" (2013)\nRoman sur l'immigration, l'identité raciale et le retour au pays. Ifemelu, une jeune Nigériane, émigre aux États-Unis et découvre ce que signifie être \"noire\" en Amérique.\n\n**Son impact :**\n- Sa conférence TED \"The Danger of a Single Story\" (2009) a été vue plus de 30 millions de fois\n- \"We Should All Be Feminists\" (2014) est devenu un manifeste féministe mondial\n- Elle a popularisé les questions de genre et d'identité africaine auprès d'un public international",
            'ordre' => 1,
        ]);

        $m3c2 = ModuleContenu::create([
            'module_id' => $module3->id,
            'type' => 'texte',
            'titre' => 'Mohamed Mbougar Sarr et le Prix Goncourt',
            'description' => 'L\'auteur sénégalais et la reconnaissance internationale.',
            'contenu' => "**Mohamed Mbougar Sarr** (Sénégal, né en 1990) est devenu en 2021 le premier auteur d'Afrique subsaharienne à recevoir le Prix Goncourt.\n\n**\"La plus secrète mémoire des hommes\" (2021)**\nCe roman raconte l'histoire de Diégane Latyr Faye, un jeune écrivain sénégalais qui part à la recherche d'un auteur mystérieux, T.C. Elimane, dont le livre publié en 1938 a été célébré puis oublié. Le roman est un hommage à la littérature et une réflexion sur ce que signifie écrire en Afrique.\n\nLe livre s'inspire librement de l'histoire de Yambo Ouologuem, auteur malien du \"Devoir de violence\" (1968), qui avait remporté le Prix Renaudot avant d'être accusé de plagiat.\n\n**Autres auteurs contemporains majeurs :**\n\n- **Alain Mabanckou** (Congo) : \"Mémoires de porc-épic\" (Prix Renaudot 2006), \"Petit Piment\" (2015). Il mêle humour, tendresse et critique sociale.\n\n- **Léonora Miano** (Cameroun) : \"Contours du jour qui vient\" (Prix Goncourt des lycéens 2006). Elle explore l'identité afro-descendante.\n\n- **Scholastique Mukasonga** (Rwanda) : \"Notre-Dame du Nil\" (Prix Renaudot 2012). Elle témoigne du génocide rwandais.\n\n- **Abdoulaye Imorou** : Nouvelles voix critiques qui repensent la place de l'Afrique dans la mondialisation littéraire.",
            'ordre' => 2,
        ]);

        $m3c3 = ModuleContenu::create([
            'module_id' => $module3->id,
            'type' => 'texte',
            'titre' => 'Conclusion : L\'avenir de la littérature africaine',
            'description' => 'Tendances actuelles et perspectives futures.',
            'contenu' => "La littérature africaine contemporaine connaît un essor sans précédent. Voici les tendances qui la caractérisent :\n\n**1. Diversification des genres**\nAu-delà du roman réaliste, les auteurs africains explorent :\n- La science-fiction (Afrofuturisme) : Nnedi Okofor, \"Binti\" (2015)\n- Le polar : Deon Meyer (Afrique du Sud), Moussa Konaté (Mali)\n- La bande dessinée : Marguerite Abouet, \"Aya de Yopougon\"\n- La poésie contemporaine : Warsan Shire (Somalie-UK)\n\n**2. Les femmes au premier plan**\nLes auteures africaines sont de plus en plus visibles :\n- Chimamanda Ngozi Adichie, Léonora Miano, Scholastique Mukasonga\n- Elles abordent le féminisme, le corps, la sexualité avec liberté\n\n**3. La question linguistique**\nLe débat continue entre écriture en langues européennes et langues africaines. Ngugi wa Thiong'o reste un fervent défenseur des langues africaines, tandis que d'autres auteurs revendiquent le droit d'écrire dans la langue de leur choix.\n\n**4. La littérature numérique**\nLes plateformes en ligne et les blogs ont permis l'émergence de nouvelles voix hors des circuits d'édition traditionnels.\n\n**5. Reconnaissance internationale**\nPrix Nobel (Wole Soyinka 1986, Nadine Gordimer 1991, J.M. Coetzee 2003, Abdulrazak Gurnah 2021), Goncourt, Booker : les prix littéraires s'ouvrent de plus en plus aux auteurs africains.\n\nLa littérature africaine n'a jamais été aussi vivante, diverse et influente qu'aujourd'hui.",
            'ordre' => 3,
        ]);

        // Quiz du Module 3
        $quiz3 = Quiz::create([
            'module_id' => $module3->id,
            'formation_id' => $formation->id,
            'titre' => 'Quiz : La Littérature Contemporaine',
            'description' => 'Testez vos connaissances sur la littérature africaine contemporaine.',
            'duree_minutes' => 10,
            'note_passage' => 60,
            'nombre_tentatives' => 3,
            'afficher_reponses' => true,
            'melanger_questions' => false,
            'melanger_options' => false,
            'active' => true,
        ]);

        // Q1 - QCM
        $q8 = QuizQuestion::create([
            'quiz_id' => $quiz3->id,
            'question' => 'Quel roman de Chimamanda Ngozi Adichie se déroule pendant la guerre du Biafra ?',
            'type' => 'qcm',
            'points' => 2,
            'ordre' => 1,
            'explication' => '"Half of a Yellow Sun" (L\'autre moitié du soleil, 2006) se déroule pendant la guerre du Biafra au Nigeria (1967-1970).',
        ]);
        QuestionOption::create(['question_id' => $q8->id, 'option_text' => 'Purple Hibiscus', 'is_correct' => false, 'ordre' => 1]);
        QuestionOption::create(['question_id' => $q8->id, 'option_text' => 'Americanah', 'is_correct' => false, 'ordre' => 2]);
        QuestionOption::create(['question_id' => $q8->id, 'option_text' => 'Half of a Yellow Sun', 'is_correct' => true, 'ordre' => 3]);
        QuestionOption::create(['question_id' => $q8->id, 'option_text' => 'We Should All Be Feminists', 'is_correct' => false, 'ordre' => 4]);

        // Q2 - QCM
        $q9 = QuizQuestion::create([
            'quiz_id' => $quiz3->id,
            'question' => 'Qui a été le premier auteur d\'Afrique subsaharienne à recevoir le Prix Goncourt ?',
            'type' => 'qcm',
            'points' => 2,
            'ordre' => 2,
            'explication' => 'Mohamed Mbougar Sarr, auteur sénégalais, a reçu le Prix Goncourt en 2021 pour "La plus secrète mémoire des hommes".',
        ]);
        QuestionOption::create(['question_id' => $q9->id, 'option_text' => 'Alain Mabanckou', 'is_correct' => false, 'ordre' => 1]);
        QuestionOption::create(['question_id' => $q9->id, 'option_text' => 'Mohamed Mbougar Sarr', 'is_correct' => true, 'ordre' => 2]);
        QuestionOption::create(['question_id' => $q9->id, 'option_text' => 'Léonora Miano', 'is_correct' => false, 'ordre' => 3]);
        QuestionOption::create(['question_id' => $q9->id, 'option_text' => 'Scholastique Mukasonga', 'is_correct' => false, 'ordre' => 4]);

        // Q3 - Vrai/Faux
        $q10 = QuizQuestion::create([
            'quiz_id' => $quiz3->id,
            'question' => 'Wole Soyinka (Nigeria) a été le premier Africain à recevoir le Prix Nobel de littérature.',
            'type' => 'vrai_faux',
            'points' => 1,
            'ordre' => 3,
            'explication' => 'Vrai. Wole Soyinka a reçu le Prix Nobel de littérature en 1986, devenant le premier Africain lauréat de ce prix.',
        ]);
        QuestionOption::create(['question_id' => $q10->id, 'option_text' => 'Vrai', 'is_correct' => true, 'ordre' => 1]);
        QuestionOption::create(['question_id' => $q10->id, 'option_text' => 'Faux', 'is_correct' => false, 'ordre' => 2]);

        // Q4 - Choix multiple
        $q11 = QuizQuestion::create([
            'quiz_id' => $quiz3->id,
            'question' => 'Quels genres littéraires sont explorés par les auteurs africains contemporains ? (Sélectionnez toutes les bonnes réponses)',
            'type' => 'choix_multiple',
            'points' => 3,
            'ordre' => 4,
            'explication' => 'La littérature africaine contemporaine s\'est diversifiée bien au-delà du roman réaliste, incluant la science-fiction (Afrofuturisme), le polar et la bande dessinée.',
        ]);
        QuestionOption::create(['question_id' => $q11->id, 'option_text' => 'Science-fiction (Afrofuturisme)', 'is_correct' => true, 'ordre' => 1]);
        QuestionOption::create(['question_id' => $q11->id, 'option_text' => 'Polar', 'is_correct' => true, 'ordre' => 2]);
        QuestionOption::create(['question_id' => $q11->id, 'option_text' => 'Bande dessinée', 'is_correct' => true, 'ordre' => 3]);
        QuestionOption::create(['question_id' => $q11->id, 'option_text' => 'Aucun de ces genres', 'is_correct' => false, 'ordre' => 4]);

        // Q5 - QCM
        $q12 = QuizQuestion::create([
            'quiz_id' => $quiz3->id,
            'question' => 'Quel est le titre de la conférence TED célèbre de Chimamanda Ngozi Adichie ?',
            'type' => 'qcm',
            'points' => 2,
            'ordre' => 5,
            'explication' => '"The Danger of a Single Story" (Le danger de l\'histoire unique) est sa conférence TED de 2009, vue plus de 30 millions de fois.',
        ]);
        QuestionOption::create(['question_id' => $q12->id, 'option_text' => 'The Power of Stories', 'is_correct' => false, 'ordre' => 1]);
        QuestionOption::create(['question_id' => $q12->id, 'option_text' => 'The Danger of a Single Story', 'is_correct' => true, 'ordre' => 2]);
        QuestionOption::create(['question_id' => $q12->id, 'option_text' => 'We Should All Be Feminists', 'is_correct' => false, 'ordre' => 3]);
        QuestionOption::create(['question_id' => $q12->id, 'option_text' => 'African Voices Matter', 'is_correct' => false, 'ordre' => 4]);

        $this->command->info("Module 3 créé : {$module3->titre} (3 contenus, 1 quiz avec 5 questions)");

        // ============================================================
        // 6. RÉSUMÉ FINAL
        // ============================================================
        $this->command->newLine();
        $this->command->info('==============================================');
        $this->command->info('  FORMATION DE TEST CRÉÉE AVEC SUCCÈS');
        $this->command->info('==============================================');
        $this->command->newLine();
        $this->command->table(
            ['Élément', 'Détail'],
            [
                ['Formation', $formation->titre . ' (ID: ' . $formation->id . ')'],
                ['Type', 'Gratuite'],
                ['Niveau', 'Débutant'],
                ['Modules', '3 modules'],
                ['Contenus', '8 contenus (texte)'],
                ['Quizzes', '3 quizzes (1 par module)'],
                ['Questions', '12 questions au total'],
                ['Note de passage', '60% par quiz, 70% pour certification'],
            ]
        );
        $this->command->newLine();
        $this->command->info('Utilisateur de test :');
        $this->command->info('  Email    : testeur@colibri.test');
        $this->command->info('  Mot de passe : password123');
        $this->command->newLine();
        $this->command->info('Parcours de test :');
        $this->command->info('  1. Se connecter avec testeur@colibri.test');
        $this->command->info('  2. Aller sur la page formations');
        $this->command->info('  3. S\'inscrire à "Introduction à la Littérature Africaine" (gratuit)');
        $this->command->info('  4. Suivre le Module 1 → lire les 3 contenus → passer le Quiz 1');
        $this->command->info('  5. Suivre le Module 2 → lire les 2 contenus → passer le Quiz 2');
        $this->command->info('  6. Suivre le Module 3 → lire les 3 contenus → passer le Quiz 3');
        $this->command->info('  7. Vérifier que la formation passe en statut "terminé"');
        $this->command->info('  8. Vérifier l\'envoi de l\'email admin pour le certificat');
        $this->command->newLine();
    }
}
