<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Agency;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    private $cities = [
        // الولايات الرئيسية مع جميع المرادفات
        'adrar' => '01',
        'أدرار' => '01',
        'ادرار' => '01',
        
        'chlef' => '02',
        'الشلف' => '02',
        'الأصنام' => '02',
        'الاصنام' => '02',
        
        'laghouat' => '03',
        'الأغواط' => '03',
        'الاغواط' => '03',
        
        'oum el bouaghi' => '04',
        'أم البواقي' => '04',
        'ام البواقي' => '04',
        
        'batna' => '05',
        'باتنة' => '05',
        
        'bejaia' => '06',
        'بجاية' => '06',
        'ڤجاية' => '06',
        
        'biskra' => '07',
        'بسكرة' => '07',
        
        'bechar' => '08',
        'بشار' => '08',
        
        'blida' => '09',
        'البليدة' => '09',
        
        'bouira' => '10',
        'البويرة' => '10',
        
        'tamanrasset' => '11',
        'تمنراست' => '11',
        'تامنراست' => '11',
        
        'tebessa' => '12',
        'تبسة' => '12',
        
        'tlemcen' => '13',
        'تلمسان' => '13',
        
        'tiaret' => '14',
        'تيارت' => '14',
        
        'tizi ouzou' => '15',
        'تيزي وزو' => '15',
        'تيزي_وزو' => '15',
        
        'alger' => '16',
        'algiers' => '16',
        'الجزائر' => '16',
        'العاصمة' => '16',
        'الجزائر العاصمة' => '16',
        
        'djelfa' => '17',
        'الجلفة' => '17',
        
        'jijel' => '18',
        'جيجل' => '18',
        'جيجيل' => '18',
        
        'setif' => '19',
        'سطيف' => '19',
        
        'saida' => '20',
        'سعيدة' => '20',
        
        'skikda' => '21',
        'سكيكدة' => '21',
        'فيليبفيل' => '21',
        
        'sidi bel abbes' => '22',
        'sidi belabbès' => '22',
        'سيدي بلعباس' => '22',
        
        'annaba' => '23',
        'عنابة' => '23',
        'بونة' => '23',
        
        'guelma' => '24',
        'قالمة' => '24',
        
        'constantine' => '25',
        'قسنطينة' => '25',
        
        'medea' => '26',
        'المدية' => '26',
        
        'mostaganem' => '27',
        'مستغانم' => '27',
        
        'msila' => '28',
        'المسيلة' => '28',
        
        'mascara' => '29',
        'معسكر' => '29',
        
        'ouargla' => '30',
        'ورقلة' => '30',
        
        'oran' => '31',
        'وهران' => '31',
        
        'el bayadh' => '32',
        'البيض' => '32',
        
        'illizi' => '33',
        'إيليزي' => '33',
        'ايليزي' => '33',
        
        'bordj bou arreridj' => '34',
        'برج بوعريريج' => '34',
        
        'boumerdes' => '35',
        'بومرداس' => '35',
        
        'el tarf' => '36',
        'الطارف' => '36',
        
        'tindouf' => '37',
        'تندوف' => '37',
        
        'tissemsilt' => '38',
        'تيسمسيلت' => '38',
        
        'el oued' => '39',
        'الوادي' => '39',
        
        'khenchela' => '40',
        'خنشلة' => '40',
        
        'souk ahras' => '41',
        'soukahras' => '41',
        'سوق أهراس' => '41',
        'سوق اهراس' => '41',
        'سوق_أهراس' => '41',
        
        'tipaza' => '42',
        'تيبازة' => '42',
        'تيبازه' => '42',
        
        'mila' => '43',
        'ميلة' => '43',
        
        'ain defla' => '44',
        'عين الدفلى' => '44',
        'عين_الدفلى' => '44',
        
        'naama' => '45',
        'النعامة' => '45',
        
        'ain temouchent' => '46',
        'عين تموشنت' => '46',
        'عين_تموشنت' => '46',
        
        'ghardaia' => '47',
        'غرداية' => '47',
        
        'relizane' => '48',
        'غليزان' => '48',
        
        // الولايات الصحراوية الجديدة
        'timimoun' => '49',
        'تيميمون' => '49',
        
        'bordj badji mokhtar' => '50',
        'برج باجي مختار' => '50',
        
        'ouled djellal' => '51',
        'أولاد جلال' => '51',
        
        'beni abbes' => '52',
        'بني عباس' => '52',
        
        'in salah' => '53',
        'عين صالح' => '53',
        'عين_صالح' => '53',
        
        'in guezzam' => '54',
        'عين قزام' => '54',
        'عين_قزام' => '54',
        
        'touggourt' => '55',
        'تقرت' => '55',
        
        'djanet' => '56',
        'جانت' => '56',
        
        'el mghair' => '57',
        'المغير' => '57',
        
        'el menia' => '58',
        'المنيعة' => '58',
    
        // المدن الكبرى والبلديات المشهورة
        'bab ezzouar' => '16',
        'باب الزوار' => '16',
        
        'hussen dey' => '16',
        'حسين داي' => '16',
        
        'kouba' => '16',
        'القبة' => '16',
        
        'birkhadem' => '16',
        'بئر خادم' => '16',
        
        'dar el beida' => '16',
        'الدار البيضاء' => '16',
        
        'rouiba' => '16',
        'الرويبة' => '16',
        
        'cherchell' => '42',
        'شرشال' => '42',
        
        'ain benian' => '16',
        'عين البنيان' => '16',
        
        'zeralda' => '16',
        'زرالدة' => '16',
        
        'staoueli' => '16',
        'سطاوالي' => '16',
        
        'boumerdes city' => '35',
        'مدينة بومرداس' => '35',
        
        'reghaia' => '16',
        'الرغاية' => '16',
        
        'baraki' => '16',
        'براقي' => '16',
        
        'sidi moussa' => '16',
        'سيدي موسى' => '16',
        
        'bordj el kiffan' => '16',
        'برج الكيفان' => '16',
        
        'el achour' => '16',
        'العاشور' => '16',
        
        'les eucalyptus' => '16',
        'الكاليتوس' => '16',
        
        'bordj el bahri' => '16',
        'برج البحري' => '16',
        
        'ben aknoun' => '16',
        'بن عكنون' => '16',
        
        'dellys' => '35',
        'دلس' => '35',
        
        'tizi ghenif' => '15',
        'تيزي غنيف' => '15',
        
        'tigzirt' => '15',
        'تقرت' => '15',
        
        'azazga' => '15',
        'أزفون' => '15',
        
        'tadmait' => '15',
        'تادمايت' => '15',
        
        'makouda' => '15',
        'ماكودة' => '15',
        
        'draa ben khedda' => '15',
        'ذراع بن خدة' => '15',
        
        'thenia' => '35',
        'الثنية' => '35',
        
        'boudouaou' => '35',
        'بودواو' => '35',
        
        'khemis el khechna' => '35',
        'خميس الخشنة' => '35',
        
        'bordj menaiel' => '35',
        'برج منايل' => '35',
        
        'naciria' => '35',
        'الناصرية' => '35',
        
        'baghlia' => '35',
        'بغلية' => '35',
        
        'sidi daoud' => '35',
        'سيدي داود' => '35',
        
        'beni amrane' => '35',
        'بني عمران' => '35',
        
        'souk el had' => '35',
        'سوق الحد' => '35',
        
        'larbatache' => '35',
        'الاربعطاش' => '35',
        
        'corso' => '35',
        'كورسو' => '35',
        
        'el marsa' => '16',
        'المرسى' => '16',
        
        'bouzareah' => '16',
        'بوزريعة' => '16',
        
        'el biar' => '16',
        'الابيار' => '16',
        
        'beni messous' => '16',
        'بني مسوس' => '16',
        
        'djasr kasentina' => '16',
        'جسر قسنطينة' => '16',
        
        'hydra' => '16',
        'حيدرة' => '16',
        
        'beni mered' => '09',
        'بني مراد' => '09',
        
        'oued el alleug' => '09',
        'وادي العلايق' => '09',
        
        'boufarik' => '09',
        'بوفاريك' => '09',
        
        'larbaa' => '09',
        'الأربعاء' => '09',
        
        'bouinan' => '09',
        'بوعينان' => '09',
        
        'soumaa' => '09',
        'السوامع' => '09',
        
        'meftah' => '09',
        'مفتاح' => '09',
        
        'blida city' => '09',
        'مدينة البليدة' => '09',
        
        'oued essalem' => '09',
        'وادي السلام' => '09',
        
        'mouzaia' => '09',
        'موزاية' => '09',
        
        'bougara' => '09',
        'بوقرة' => '09',
        
        'gueblia' => '09',
        'قبلية' => '09',
        
        'hammam melouane' => '09',
        'حمام ملوان' => '09',
        
        'souhane' => '09',
        'السحانة' => '09',
        
        'chebli' => '09',
        'الشبلي' => '09',
        
        'beni tamou' => '09',
        'بني تامو' => '09',
        
        'bouarfa' => '09',
        'بوعرفة' => '09',
        
        'tibahia' => '09',
        'تيباحية' => '09',
        
        'ben chicao' => '09',
        'بن شيكاو' => '09',
        
        'djebabra' => '09',
        'جبابرة' => '09',
        
        'ain romana' => '09',
        'عين الرمانة' => '09',
        
        'messaoud said' => '09',
        'مسعود سعيد' => '09',
        
        'beni khellef' => '09',
        'بني خلف' => '09',
        
        'souagui' => '09',
        'السواقي' => '09',
        
        'aïn benian' => '16',
        'عين البنيان' => '16',
        
        'el achour' => '16',
        'العاشور' => '16',
        
        'el magharia' => '16',
        'المغيرية' => '16',
        
        'ben aknoun' => '16',
        'بن عكنون' => '16',
        
        'dely brahim' => '16',
        'دالي ابراهيم' => '16',
        
        'bouchaoui' => '16',
        'بوشاوي' => '16',
        
        'douera' => '16',
        'الدويرة' => '16',
        
        'draria' => '16',
        'الدرارية' => '16',
        
        'khraicia' => '16',
        'خرايسية' => '16',
        
        'saoula' => '16',
        'السحاولة' => '16',
        
        'el biar' => '16',
        'الابيار' => '16',
        
        'bologhine' => '16',
        'بولوغين' => '16',
        
        'hamma' => '16',
        'الحامة' => '16',
        
        'belouizdad' => '16',
        'بلوزداد' => '16',
        
        'bab el oued' => '16',
        'باب الوادي' => '16',
        
        'casbah' => '16',
        'القصبة' => '16',
        
        'sidi mhamed' => '16',
        'سيدي امحمد' => '16',
        
        'el madania' => '16',
        'المدنية' => '16',
        
        'el mouradia' => '16',
        'المرادية' => '16',
        
        'bir mourad rais' => '16',
        'بئر مراد رايس' => '16',
        
        'birkadem' => '16',
        'بئر خادم' => '16',
        
        'bourouba' => '16',
        'بوروبة' => '16',
        
        'el harrach' => '16',
        'الحراش' => '16',
        
        'hammamet' => '16',
        'الحمامات' => '16',
        
        'baraki' => '16',
        'براقي' => '16',
        
        'kouba' => '16',
        'القبة' => '16',
        
        'bordj el bahri' => '16',
        'برج البحري' => '16',
        
        'el marsa' => '16',
        'المرسى' => '16',
        
        'ain taya' => '16',
        'عين طاية' => '16',
        
        'bordj el kiffan' => '16',
        'برج الكيفان' => '16',
        
        'el kettani' => '16',
        'الكتاني' => '16',
        
        'el hamiz' => '16',
        'الحميز' => '16',
        
        'dar el beida' => '16',
        'الدار البيضاء' => '16',
        
        'bab ezzouar' => '16',
        'باب الزوار' => '16',
        
        'bordj el bahri' => '16',
        'برج البحري' => '16',
        
        'deux bassins' => '16',
        'الحوضين' => '16',
        
        'el achour' => '16',
        'العاشور' => '16',
        
        'el biar' => '16',
        'الابيار' => '16',
        
        'el mouradia' => '16',
        'المرادية' => '16',
        
        'hamma annassers' => '16',
        'حامة العناصر' => '16',
        
        'kouba' => '16',
        'القبة' => '16',
        
        'mohammadia' => '16',
        'المحمدية' => '16',
        
        'oued koriche' => '16',
        'وادي قريش' => '16',
        
        'raïs hamidou' => '16',
        'الرايس حميدو' => '16',
        
        'reghaïa' => '16',
        'الرغاية' => '16',
        
        'sidi mhamed' => '16',
        'سيدي امحمد' => '16',
        
        'tessala el merdja' => '16',
        'تسالة المرجة' => '16',
        
        'zeralda' => '16',
        'زرالدة' => '16'
    ];

    private $greetings = [
        'مرحبا', 'اهلا', 'سلام', 'السلام عليكم', 'صباح الخير', 'مساء الخير',
        'hello', 'hi', 'hey', 'good morning', 'good evening', 'bonjour', 'salut'
    ];

    private $farewells = [
        'مع السلامة', 'الى اللقاء', 'وداعا', 'اراك لاحقا',
        'goodbye', 'bye', 'see you', 'au revoir'
    ];

    private $thanks = [
        'شكرا', 'متشكر', 'ممنون', 'مقدر', 'يعطيك الصحة',
        'thanks', 'thank you', 'merci', 'gracias'
    ];

    private $fuelTranslations = [
        'بنزين' => 'petrol', 'مازوت' => 'diesel', 'كهربائية' => 'electric',
        'هايبرد' => 'hybrid', 'هجينة' => 'hybrid', 'petrol' => 'petrol',
        'diesel' => 'diesel', 'electric' => 'electric', 'hybrid' => 'hybrid'
    ];

    private $arabicToLatinModels = [ 
        'كليو' => 'clio', 'بولو' => 'polo', 'غولف' => 'golf', 'قولف' => 'golf',
        'ياريس' => 'yaris', 'سيفيك' => 'civic', 'كامري' => 'camry',
        'بيكانتو' => 'picanto', 'سيمبول' => 'symbol', 'ايبيزا' => 'ibiza',
        'استرا' => 'astra', 'موديل 3' => 'model 3', 'تيسلا' => 'tesla',
        'مرسيدس' => 'mercedes', 'رينو' => 'renault', 'فورد' => 'ford',
        'هيونداي' => 'hyundai', 'بيجو' => 'peugeot', 'نيسان' => 'nissan',
        'تويوتا' => 'toyota', 'لكزس' => 'lexus', 'مازدا' => 'mazda',
        'سوبارو' => 'subaru', 'ميتسوبيشي' => 'mitsubishi', 'هوندا' => 'honda',
        'كيا' => 'kia', 'شفروليه' => 'chevrolet', 'جيلي' => 'geely',
        'فولكسفاجن' => 'volkswagen', 'أودي' => 'audi', 'بي ام دبليو' => 'bmw',
        'فولفو' => 'volvo', 'جاغوار' => 'jaguar', 'لاند روفر' => 'land rover',
        'بنتلي' => 'bentley', 'بورش' => 'porsche', 'فيراري' => 'ferrari',
        'لامبورغيني' => 'lamborghini', 'مكلارين' => 'mclaren', 'أستون مارتن' => 'aston martin',
        'كرايسلر' => 'chrysler', 'دودج' => 'dodge', 'جيب' => 'jeep',
        'سانج يونج' => 'ssangyong', 'سيات' => 'seat', 'سكودا' => 'skoda',
        'دايهاتسو' => 'daihatsu', 'سوزوكي' => 'suzuki', 'ايسوزو' => 'isuzu',
        'كاديلاك' => 'cadillac', 'لينكولن' => 'lincoln', 'باك' => 'buick',
        'شيري' => 'chery', 'بريليانس' => 'brilliance', 'جاك' => 'jac',
        'هافال' => 'haval', 'فاو' => 'faw', 'زوتي' => 'zotye',
        'مايتسو' => 'maxus', 'رام' => 'ram', 'تاتا' => 'tata',
        'ماهيندرا' => 'mahindra', 'ماروتي' => 'maruti', 'بروتون' => 'proton',
        'بيرود' => 'perodua', 'فيات' => 'fiat', 'الفا روميو' => 'alfa romeo',
        'لانشيا' => 'lancia', 'ميني' => 'mini', 'سمارت' => 'smart',
        'رولز رويس' => 'rolls royce', 'مازيراتي' => 'maserati', 'بوجاتي' => 'bugatti',
        'كوبرا' => 'cupra', 'لوتس' => 'lotus', 'مورغان' => 'morgan',
        'تريومف' => 'triumph', 'ساب' => 'saab', 'هومر' => 'hummer',
        'سكيون' => 'scion', 'ساتورن' => 'saturn', 'بونتياك' => 'pontiac',
        'أوبل' => 'opel', 'فوكسهول' => 'vauxhall', 'داسيا' => 'dacia',
        'لادا' => 'lada', 'موسكوفيتش' => 'moskvich', 'فاز' => 'uaz',
        'جريت وول' => 'great wall', 'بي واي دي' => 'byd', 'ليفان' => 'lifan',
        'دونج فنغ' => 'dongfeng', 'انفينيتي' => 'infiniti',
        'ايكوس' => 'acura', 'جنيسيس' => 'genesis', 'ميتسووكا' => 'mitsuoka'
    ];

    private $unclearPatterns = [
        
      
    ];
    private $featureTranslations = [
        'family' => ['family', 'familial', 'family car', 'عائلي', 'عائلية', 'عائلات', 'أطفال', 'اطفال', 'للأسرة', 'اسرية'],
        'seats' => ['seats', 'places', 'persons', 'مقاعد', 'كراسي', 'أشخاص', 'ركاب'],
        'child_seat' => ['child seat', 'baby seat', 'كرسي أطفال', 'مقعد اطفال', 'كرسي الاطفال', 'مقعد الطفل'],
        'air_conditioning' => ['ac', 'air con', 'air conditioning', 'تكييف', 'مكيف', 'تكييف هواء']
    ];
    private $carRelatedKeywords = [
        'سيارة', 'سيارات', 'car', 'cars', 'voiture', 'véhicule',
        'تأجير', 'ايجار', 'rent', 'location', 'حجز', 'booking', 'reservation',
        'ماركة', 'brand', 'موديل', 'model', 'نوع', 'type', 'طراز',
        'سعر', 'price', 'تكلفة', 'cost', 'قيمة', 'value', 'ثمن', 'بكام',
        'وقود', 'fuel', 'carburant', 'بنزين', 'ديزل', 'كهرباء', 'هايبرد',
        'محرك', 'engine', 'motor', 'عجلات', 'wheels', 'roues', 'إطارات',
        'لون', 'color', 'couleur', 'ألوان', 'colors', 'couleurs', 'أسود', 'أبيض',
        'مقاعد', 'seats', 'sièges', 'أبواب', 'doors', 'portes', 'ركاب',
        'مكيف', 'ac', 'climatisation', 'تكييف', 'هواء',
        'توصيل', 'delivery', 'livraison', 'استلام', 'تسليم',
        'تأمين', 'insurance', 'assurance', 'ضمان', 'تغطية',
        'شروط', 'conditions', 'terms', 'متطلبات', 'مستندات',
        'دفع', 'payment', 'paiement', 'كاش', 'نقدي', 'بطاقة',
        'حساب', 'bill', 'facture', 'فاتورة', 'إيصال',
        'خصم', 'discount', 'réduction', 'عرض', 'offer', 'promo',
        'جديد', 'new', 'nouveau', 'مستعمل', 'used', 'occasion',
        'سرعة', 'speed', 'vitesse', 'قوة', 'power', 'puissance',
        'اقتصاد', 'economy', 'économique', 'استهلاك', 'consumption',
        'أمان', 'safety', 'sécurité', 'ميزات', 'features', 'caractéristiques',
        'مدة', 'duration', 'durée', 'يوم', 'day', 'jour', 'أسبوع', 'شهر',
        'بحث', 'search', 'recherche', 'فلتر', 'filter', 'filtrer',
        'متاحة', 'available', 'disponible', 'محجوزة', 'reserved', 'loué',
        'صورة', 'image', 'photo', 'صور', 'images', 'photos',
        'تقييم', 'rating', 'évaluation', 'نجمة', 'star', 'étoile',
        'وكالة', 'agency', 'agence', 'فرع', 'branch', 'succursale',
        'موقع', 'location', 'emplacement', 'عنوان', 'address', 'adresse',
        'اتصال', 'contact', 'phone', 'تليفون', 'هاتف', 'رقم',
        'رخصة', 'license', 'permis', 'قيادة', 'driving', 'conduite',
        'عمر', 'age', 'âge', 'حد', 'limit', 'limite',
        'إيداع', 'deposit', 'caution', 'تأميني', 'security',
        'إلغاء', 'cancel', 'annulation', 'استرجاع', 'refund', 'remboursement',
        'تأخير', 'delay', 'retard', 'غرامة', 'fine', 'amende',
        'تقرير', 'report', 'rapport', 'حالة', 'status', 'état',
        'صيانة', 'maintenance', 'entretien', 'إصلاح', 'repair', 'réparation',
        'قطع', 'parts', 'pièces', 'غيار', 'spare', 'rechange',
        'دليل', 'guide', 'manual', 'تعليمات', 'instructions', 'إرشادات'
    ];

    private $userContext = [];

    public function respond(Request $request)
    {
        try {
            $userMessage = strtolower(trim($request->message));
            $userId = $request->user_id ?? 'guest';

            // معالجة الترحيب والوداع والشكر
            if ($this->isGreeting($userMessage)) {
                $this->updateContext($userId, ['last_interaction' => 'greeting']);
                return response()->json([
                    'reply' => $this->generateGreetingResponse(),
                    'car_results' => []
                ]);
            }

            if ($this->isFarewell($userMessage)) {
                unset($this->userContext[$userId]);
                return response()->json([
                    'reply' => $this->generateFarewellResponse(),
                    'car_results' => []
                ]);
            }

            if ($this->isThanks($userMessage)) {
                return response()->json([
                    'reply' => $this->generateThanksResponse(),
                    'car_results' => []
                ]);
            }

            // التحقق من الأسئلة الشائعة
            $faqResponse = $this->checkFaq($userMessage);
            if ($faqResponse) {
                return response()->json([
                    'reply' => $faqResponse,
                    'car_results' => []
                ]);
            }

            // التحقق إذا كان السؤال غير واضح
            if ($this->isUnclearRequest($userMessage)) {
                return response()->json([
                    'reply' => $this->generateUnclearResponse(),
                    'car_results' => []
                ]);
            }

            // معالجة طلب السيارات
            return $this->processCarRequest($userMessage, $userId);

        } catch (\Exception $e) {
            Log::error('Chat error: '.$e->getMessage());
            return response()->json([
                'reply' => 'عذراً، حدث خطأ تقني. يرجى المحاولة مرة أخرى.',
                'error' => true
            ]);
        }
    }

    private function isUnclearRequest($message)
    {
        foreach ($this->unclearPatterns as $pattern) {
            if (str_contains($message, $pattern)) {
                return true;
            }
        }
        return false;
    }

    private function isCarRelatedRequest($message)
    {
        // تحقق أولاً من الكلمات الأساسية المتعلقة بالسيارات
        $hasCarKeyword = false;
        foreach ($this->carRelatedKeywords as $keyword) {
            if (str_contains($message, $keyword)) {
                $hasCarKeyword = true;
                break;
            }
        }
        
        // إذا وجد كلمة متعلقة بالسيارات، نعتبر الطلب صحيحاً حتى لو لم يتعرف على باقي التفاصيل
        if ($hasCarKeyword) {
            return true;
        }
        
        // تحقق من المدن والموديلات إذا لم يكن هناك كلمات سيارة واضحة
        return $this->detectCity($message) !== null || 
               $this->detectCarModel($message) !== null ||
               $this->detectBrand($message) !== null;
    }

    private function generateUnclearResponse()
    {
        $responses = [
            "عذرًا، لم أفهم طلبك بالكامل. هل يمكنك إعادة صياغته بشكل أوضح؟",
            "أعتذر، يبدو أنني لم أتمكن من فهم ما تقصده. هل يمكنك توضيح طلبك؟",
            "لم أتمكن من تحديد ما تبحث عنه بالضبط. هل يمكنك إعطائي المزيد من التفاصيل؟",
            "يبدو أن سؤالك غير واضح بالنسبة لي. هل يمكنك إعادة صياغته بطريقة أخرى؟",
            "أنا متخصص في مساعدتك بحجز السيارات. هل يمكنك توضيح طلبك المتعلق بالسيارات؟"
        ];

        return $responses[array_rand($responses)];
    }

    private function updateContext($userId, $data)
    {
        if (!isset($this->userContext[$userId])) {
            $this->userContext[$userId] = [];
        }
        $this->userContext[$userId] = array_merge($this->userContext[$userId], $data);
    }

    private function isGreeting($message)
    {
        foreach ($this->greetings as $greeting) {
            if (str_contains($message, $greeting)) {
                return true;
            }
        }
        return false;
    }

    private function isFarewell($message)
    {
        foreach ($this->farewells as $farewell) {
            if (str_contains($message, $farewell)) {
                return true;
            }
        }
        return false;
    }

    private function isThanks($message)
    {
        foreach ($this->thanks as $thank) {
            if (str_contains($message, $thank)) {
                return true;
            }
        }
        return false;
    }

    private function generateGreetingResponse()
    {
        $responses = [
            "أهلاً وسهلاً بك! 😊 كيف يمكنني مساعدتك في العثور على السيارة المثالية لك اليوم؟",
            "مرحباً بك في خدمة حجز السيارات! 🚗 هل تبحث عن سيارة معينة؟ يمكنك إخباري بالموديل أو المدينة أو نوع الوقود الذي تفضله.",
            "أهلًا وسهلًا! 👋 أنا مساعدك الذكي لمساعدتك في العثور على أفضل السيارات المتاحة. هل لديك تفضيلات معينة للسيارة التي تبحث عنها؟"
        ];
        return $responses[array_rand($responses)];
    }

    private function generateFarewellResponse()
    {
        $responses = [
            "مع السلامة! لا تتردد في العودة إذا كنت بحاجة إلى أي مساعدة أخرى. 😊 نتمنى لك رحلة سعيفة!",
            "إلى اللقاء! 🚗💨 شكراً لاختيارك خدمتنا. نأمل أن تكون قد وجدت ما تبحث عنه. إذا كان لديك أي استفسار آخر، نحن هنا لمساعدتك.",
            "وداعاً! 🌟 شكراً لاستخدامك خدمتنا. نتمنى لك يوماً رائعاً ونراكم قريباً!"
        ];
        return $responses[array_rand($responses)];
    }

    private function generateThanksResponse()
    {
        $responses = [
            "العفو! 😊 دائماً سعداء بمساعدتك. هل هناك شيء آخر تحتاجه؟ يمكنك أن تسألني عن أي شيء يتعلق بالسيارات المتاحة أو شروط الحجز.",
            "لا شكر على واجب! 💙 خدمتك هي أولويتنا. إذا كنت بحاجة إلى أي معلومات إضافية أو ترغب في حجز سيارة، فقط أخبرني.",
            "شكراً لك على كلماتك اللطيفة! 🌟 نأمل أن نكون قد ساعدنا في العثور على ما تبحث عنه. هل يمكنني مساعدتك في أي شيء آخر اليوم؟"
        ];
        return $responses[array_rand($responses)];
    }

    private function checkFaq($message)
    {
        $faqs = [
            'ساعات العمل' => ['ساعات', 'اوقات', 'متى', 'يفتح', 'يغلق', 'وقت', 'دوام'],
            'التسعير' => ['سعر', 'اسعار', 'تكلفة', 'بكام', 'ثمن', 'السعر', 'الأسعار', 'كم تكلف', 'الدفع'],
            'الشروط' => ['شروط', 'متطلبات', 'وثائق', 'اجراءات', 'رخصة', 'العمر', 'سن', 'مستندات', 'الأوراق'],
            'الدفع' => ['دفع', 'دفعة', 'الدفع', 'الدفعة', 'القسط', 'طريقة الدفع', 'كاش', 'بطاقة', 'ائتمان'],
            'التوصيل' => ['توصيل', 'توصيلة', 'توصيلية', 'للمنزل', 'للموقع', 'التسليم', 'استلام', 'توصيل السيارة'],
            'التأمين' => ['تأمين', 'ضمان', 'التغطية', 'الحوادث', 'الضرر', 'المسؤولية'],
            'الإلغاء' => ['إلغاء', 'الغاء', 'الاسترجاع', 'الاسترداد', 'الفسخ', 'إرجاع', 'التراجع']
        ];

        $answers = [
            'ساعات العمل' => "⏰ نسهر على راحتكم بلا حدود\n\nيمكنك حجز سيارة عبر الموقع الإلكتروني على مدار الساعة.",
            'التسعير' => "💰 \n\nيتم تحديد الأسعار النهائية من قبل الوكالة المالكة للسيارة بناءً على نوع المركبة ومدة التأجير    .",
            'الشروط' => "📋 شروط تأجير السيارات:\n\n1. أن يكون عمرك 21 سنة على الأقل\n2. رخصة قيادة سارية المفعول (سارية لمدة عام على الأقل)\n3. بطاقة هوية وطنية أو جواز سفر\n4. إيداع تأميني (يعتمد على نوع السيارة)\n5. بطاقة ائتمان لضمان الحجز\n\nقد تختلف الشروط حسب نوع السيارة المطلوبة.",
            'الدفع' => "💳 طرق الدفع المتاحة:\n\n- الدفع النقدي\n- بطاقات الائتمان (Visa, MasterCard)\n- التحويل البنكي\n\nملاحظات:\n- نطلب دفعة أولى 20% عند الحجز\n- الباقي يتم دفعه عند استلام السيارة\n- يوجد خصم 5% للدفع الكامل مقدمًا",
            'التوصيل' => "🚗 خدمة التوصيل:\n\n- داخل المدينة: مجاناً\n- خارج المدينة: رسوم حسب المسافة (تبدأ من 500 دج)\n- المطارات: خدمة توصيل خاصة بتكلفة إضافية\n\nيمكنك تحديد موقع التسليم عند تأكيد الحجز.",
            'التأمين' => "🛡️ بوليصة التأمين تشمل:\n\n1. تغطية ضد الحوادث والاصطدام\n2. تغطية ضد السرقة (مع وجود شروط)\n3. مسؤولية تجاه الغير\n\nملاحظة: يوجد فرق تأمين (مبلغ غير مسترد) في حالة حدوث ضرر للسيارة.",
            'الإلغاء' => "🔄 سياسة الإلغاء:\n\n- قبل 48 ساعة من الحجز: استرداد كامل المبلغ\n- قبل 24 ساعة: استرداد 50% من المبلغ\n- أقل من 24 ساعة: لا يوجد استرداد\n\nفي حالات الطوارئ (مستندة)، يرجى الاتصال بنا للتوصل إلى حل."
        ];

        foreach ($faqs as $key => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($message, $keyword)) {
                    return $answers[$key];
                }
            }
        }

        return null;
    }

    private function processCarRequest($userMessage, $userId)
{
    // تحليل رسالة المستخدم - المدينة الآن اختيارية
    $cityCode = $this->detectCity($userMessage);
    
    $fuelType = $this->detectFuelType($userMessage);
    $status = $this->detectStatus($userMessage);
    $model = $this->detectCarModel($userMessage);
    $brand = $this->detectBrand($userMessage);
    $priceRange = $this->detectPriceRange($userMessage);
    $features = $this->detectFeatures($userMessage);
    $seats = $this->detectSeatsNumber($userMessage);

    // تحديث السياق
    $this->updateContext($userId, [
        'last_search' => [
            'city' => $cityCode,
            'fuel_type' => $fuelType,
            'model' => $model,
            'brand' => $brand,
            'price_range' => $priceRange,
            'features' => $features,
            'seats' => $seats
        ],
        'last_interaction' => 'car_search'
    ]);

    // بناء الاستعلام
    $query = Car::with(['agency', 'bookings' => function ($q) {
        $q->whereIn('status', ['Confirmed', 'Pending Payment', 'Pending Approval'])
            ->where('end_date', '>=', now());
    }]);

    // تطبيق الفلاتر - المدينة الآن اختيارية
    if ($cityCode) {
        $this->applyCityFilter($query, $cityCode);
    }
    
    $this->applyFuelFilter($query, $fuelType);
    $this->applyStatusFilter($query, $status);
    $this->applyModelFilter($query, $model);
    $this->applyBrandFilter($query, $brand);
    $this->applyPriceFilter($query, $priceRange);
    $this->applyFeaturesFilter($query, $features);
    $this->applySeatsFilter($query, $seats);

    $cars = $query->take(5)->get();

    if ($cars->isEmpty()) {
        return $this->handleNoResults($userMessage, $userId);
    }

    return $this->handleResults($cars, $cityCode, $fuelType, $model, $brand, $priceRange, $features, $seats);
}
   

private function detectCity($message)
{
    // تطبيع الرسالة
    $cleanedMessage = preg_replace('/[^\p{L}\s]/u', '', strtolower($message));
    $normalizedMessage = $this->normalizeArabic($cleanedMessage);

    // أولاً: البحث في قائمة المدن المعرفة مسبقاً ($this->cities)
    foreach ($this->cities as $cityName => $code) {
        $translatedCity = $this->translateCityName($cityName);
        
        $normalizedCityName = $this->normalizeArabic($cityName);
        $normalizedTranslated = $this->normalizeArabic($translatedCity);

        if (str_contains($normalizedMessage, $normalizedCityName) || 
            str_contains($normalizedMessage, $normalizedTranslated)) {
            
            // التحقق من وجود المدينة في قاعدة البيانات
            $cityInDb = Agency::where(function($query) use ($cityName, $translatedCity) {
                $query->whereRaw('LOWER(city) = ?', [strtolower($cityName)])
                      ->orWhereRaw('LOWER(city) = ?', [strtolower($translatedCity)]);
            })->first();

            if ($cityInDb) {
                return $cityInDb->city; // إرجاع الاسم كما هو مخزن في قاعدة البيانات
            }
        }
    }

    // ثانياً: إذا لم يتم العثور في القائمة المحددة، البحث في جميع المدن الموجودة في قاعدة البيانات
    $availableCities = Agency::select('city')->distinct()->pluck('city')->toArray();

    foreach ($availableCities as $dbCity) {
        $dbCityLower = strtolower($dbCity);
        $translatedDbCity = $this->translateCityName($dbCityLower);
        
        $normalizedDbCity = $this->normalizeArabic($dbCityLower);
        $normalizedTranslatedDb = $this->normalizeArabic($translatedDbCity);

        if (str_contains($normalizedMessage, $normalizedDbCity) || 
            str_contains($normalizedMessage, $normalizedTranslatedDb)) {
            return $dbCity; // إرجاع الاسم كما هو مخزن في قاعدة البيانات
        }
    }

    // ثالثاً: محاولة مطابقة جزئية إذا فشلت المطابقة التامة
    foreach ($availableCities as $dbCity) {
        $dbCityLower = strtolower($dbCity);
        $normalizedDbCity = $this->normalizeArabic($dbCityLower);
        
        // مطابقة جزئية بدون حدود الكلمة
        if (str_contains($normalizedMessage, $normalizedDbCity)) {
            return $dbCity;
        }
    }

    return null;
}


    private function translateCityName($cityName)
    {
        $variations = [
            'adrar' => ['أدرار', 'ادرار'],
            'algiers' => ['الجزائر'],
            'oran' => ['وهران'],
            'constantine' => ['قسنطينة'],
            'annaba' => ['عنابة'],
            'blida' => ['البليدة'],
            'batna' => ['باتنة'],
            'djelfa' => ['الجلفة'],
            'setif' => ['سطيف'],
            'sidi bel abbes' => ['سيدي بلعباس'],
            'biskra' => ['بسكرة'],
            'tébessa' => ['تبسة'],
            'el oued' => ['الوادي'],
            'skikda' => ['سكيكدة'],
            'tiaret' => ['تيارت'],
            'bejaia' => ['بجاية'],
            'tlemcen' => ['تلمسان'],
            'boumerdes' => ['بومرداس'],
            'medea' => ['المدية'],
            'tizi ouzou' => ['تيزي وزو'],
            'ghardaia' => ['غرداية'],
            'mostaganem' => ['مستغانم'],
            'msila' => ['المسيلة'],
            'chlef' => ['الشلف'],
            'saida' => ['سعيدة'],
            'el tarf' => ['الطارف'],
            'laghouat' => ['الأغواط'],
            'oum el bouaghi' => ['أم البواقي'],
            'bouira' => ['البويرة'],
            'tamanrasset' => ['تمنراست'],
            'tindouf' => ['تندوف'],
            'naama' => ['النعامة'],
            'guelma' => ['قالمة'],
            'khenchela' => ['خنشلة'],
            'soukahras' => ['سوق أهراس'],
            'tipaza' => ['تيبازة'],
            'mila' => ['ميلة'],
            'ain defla' => ['عين الدفلى'],
            'ain temouchent' => ['عين تموشنت'],
            'relizane' => ['غليزان'],
            'tissemsilt' => ['تيسمسيلت'],
            'mascara' => ['معسكر'],
            'jijel' => ['جيجل'],
            'bechar' => ['بشار'],
            'el bayadh' => ['البيض'],
            'illizi' => ['إيليزي'],
            'bordj bou arreridj' => ['برج بوعريريج'],
            
        ];
    
        $cityName = strtolower(trim($cityName));
        $normalizedCityName = $this->normalizeArabic($cityName);
    
        foreach ($variations as $en => $arabicForms) {
            if ($normalizedCityName === $this->normalizeArabic($en)) {
                return $arabicForms[0];
            }
    
            foreach ($arabicForms as $arabicName) {
                if ($normalizedCityName === $this->normalizeArabic($arabicName)) {
                    return $en;
                }
            }
        }
    
        return $cityName;
    }
    
    private function normalizeArabic($text)
    {
        // توحيد الألف بأشكالها المختلفة إلى "ا"
        $text = str_replace(['أ', 'إ', 'آ'], 'ا', $text);
        // إزالة المسافات الزائدة وتوحيد الحروف الصغيرة
        return trim(mb_strtolower($text));
    }
    
    
    private function detectFuelType($message)
    {
        foreach ($this->fuelTranslations as $keyword => $type) {
            if (str_contains($message, $keyword)) {
                return $type;
            }
        }
        return null;
    }

    private function detectStatus($message)
    {
        if (str_contains($message, 'متاحة') || str_contains($message, 'متوفرة') || str_contains($message, 'disponible') || str_contains($message, 'available')) {
            return 'available';
        } elseif (str_contains($message, 'مأجورة') || str_contains($message, 'محجوزة') || str_contains($message, 'مؤجرة') || str_contains($message, 'reserved') || str_contains($message, 'loué')) {
            return 'rented';
        }
        return null;
    }

    private function detectCarModel($message)
    {
        // تنظيف الرسالة
        $cleanedMessage = preg_replace('/[؟?.,!]/u', '', strtolower($message));
        
        // التحقق من الترجمات العربية أولاً
        foreach ($this->arabicToLatinModels as $arabic => $latin) {
            if (str_contains($cleanedMessage, strtolower($arabic))) {
                return $latin;
            }
        }
        
        // البحث المباشر في قاعدة البيانات
        $models = Car::select('model')->distinct()->pluck('model')->toArray();
        foreach ($models as $model) {
            if (str_contains($cleanedMessage, strtolower($model))) {
                return $model;
            }
        }
        
        return null;
    }

    private function detectBrand($message)
    {
        $brands = Car::select('brand')->distinct()->pluck('brand')->toArray();
        foreach ($brands as $b) {
            if (str_contains($message, strtolower($b))) {
                return $b;
            }
        }
        return null;
    }

    private function detectPriceRange($message)
    {
        if (preg_match('/(أقل|اقل|under|less than|أقل من|اقل من)\s*(\d+)/', $message, $matches)) {
            return ['max' => (int)$matches[2]];
        } elseif (preg_match('/(أكثر|اكثر|above|more than|أكثر من|اكثر من)\s*(\d+)/', $message, $matches)) {
            return ['min' => (int)$matches[2]];
        } elseif (preg_match('/(بين|between|from)\s*(\d+)\s*(و|الى|to)\s*(\d+)/', $message, $matches)) {
            return ['min' => (int)$matches[2], 'max' => (int)$matches[4]];
        } elseif (preg_match('/\b(\d+)\s*(إلى|الى|to)\s*(\d+)\b/', $message, $matches)) {
            return ['min' => (int)$matches[1], 'max' => (int)$matches[3]];
        }
        return null;
    }

    private function applyCityFilter(&$query, $cityCode)
    {
        if ($cityCode) {
            $query->whereHas('agency', function ($q) use ($cityCode) {
                $q->where('city', $cityCode);
            });
        }
    }
    

    private function applyFuelFilter(&$query, $fuelType)
    {
        if ($fuelType) {
            $query->where('fuel_type', $fuelType);
        }
    }

    private function detectFeatures($message) {
        $features = [];
        $normalizedMessage = mb_strtolower(trim($message));
        
        foreach ($this->featureTranslations as $feature => $keywords) {
            // تحقق من المفتاح نفسه (مثل 'family')
            if (str_contains($normalizedMessage, mb_strtolower($feature))) {
                $features[$feature] = true;
                continue;
            }
            
            // تحقق من الكلمات المترادفة
            foreach ($keywords as $keyword) {
                if (str_contains($normalizedMessage, mb_strtolower($keyword))) {
                    $features[$feature] = true;
                    break;
                }
            }
        }
        return $features;
    }
    private function detectSeatsNumber($message)
{
    if (preg_match('/(\d+)\s*(seats|places|persons|مقاعد|كراسي|أشخاص|ركاب)/', $message, $matches)) {
        return (int)$matches[1];
    }
    return null;
}

    private function applyFeaturesFilter(&$query, $features)
    {
        if (!empty($features)) {
            foreach ($features as $feature => $value) {
                switch ($feature) {
                    case 'family':
                        $query->where('family_friendly', true);
                        break;
                    case 'child_seat':
                        $query->where('child_seat', true);
                        break;
                    case 'air_conditioning':
                        $query->where('air_conditioning', true);
                        break;
                }
            }
        }
    }

   
    
    private function applySeatsFilter(&$query, $seats)
{
    if ($seats) {
        $query->where('seats', '>=', $seats);
    }
}
    private function applyStatusFilter(&$query, $status)
    {
        if ($status === 'available') {
            $query->whereDoesntHave('bookings', function ($q) {
                $q->whereIn('status', ['Confirmed', 'Pending Payment', 'Pending Approval'])
                    ->where('end_date', '>=', now());
            });
        } elseif ($status === 'rented') {
            $query->whereHas('bookings', function ($q) {
                $q->whereIn('status', ['Confirmed', 'Pending Payment', 'Pending Approval'])
                    ->where('end_date', '>=', now());
            });
        }
    }

    private function applyModelFilter(&$query, $model)
    {
        if ($model) {
            $query->where(function($q) use ($model) {
                $q->whereRaw('LOWER(model) LIKE ?', ['%' . strtolower($model) . '%'])
                  ->orWhereRaw('LOWER(brand) LIKE ?', ['%' . strtolower($model) . '%']);
            });
        }
    }

    private function applyBrandFilter(&$query, $brand)
    {
        if ($brand) {
            $query->whereRaw('LOWER(brand) LIKE ?', ['%' . strtolower($brand) . '%']);
        }
    }

    private function applyPriceFilter(&$query, $priceRange)
    {
        if ($priceRange) {
            if (isset($priceRange['min'])) {
                $query->where('daily_rate', '>=', $priceRange['min']);
            }
            if (isset($priceRange['max'])) {
                $query->where('daily_rate', '<=', $priceRange['max']);
            }
        }
    }

    private function handleNoResults($userMessage, $userId)
    {
        $context = $this->userContext[$userId] ?? [];
        $lastSearch = $context['last_search'] ?? [];
        
        $reply = "عذراً، لم أتمكن من العثور على سيارات تطابق طلبك. 🚗💔\n\n";

        if (!empty($lastSearch)) {
            $reply .= "لقد بحثت عن:\n";
            if ($lastSearch['city']) {
                $cityNames = array_flip($this->cities);
                $cityName = $cityNames[$lastSearch['city']] ?? $lastSearch['city'];
                $reply .= "- المدينة: " . $cityName . "\n";
            }
            if ($lastSearch['brand']) {
                $reply .= "- الماركة: " . $lastSearch['brand'] . "\n";
            }
            if ($lastSearch['model']) {
                $reply .= "- الموديل: " . $lastSearch['model'] . "\n";
            }
            if ($lastSearch['fuel_type']) {
                $fuelNames = [
                    'petrol' => 'بنزين',
                    'diesel' => 'ديزل',
                    'electric' => 'كهربائية',
                    'hybrid' => 'هجينة'
                ];
                $reply .= "- نوع الوقود: " . ($fuelNames[$lastSearch['fuel_type']] ?? $lastSearch['fuel_type']) . "\n";
            }
            if ($lastSearch['price_range']) {
                $pr = $lastSearch['price_range'];
                if (isset($pr['min']) && isset($pr['max'])) {
                    $reply .= "- السعر: بين " . $pr['min'] . " و " . $pr['max'] . " دج يومياً\n";
                } elseif (isset($pr['min'])) {
                    $reply .= "- السعر: أكثر من " . $pr['min'] . " دج يومياً\n";
                } elseif (isset($pr['max'])) {
                    $reply .= "- السعر: أقل من " . $pr['max'] . " دج يومياً\n";
                }
            }
            
            $reply .= "\n";
        }

        $suggestions = [
            "قد تساعدك هذه الاقتراحات في العثور على ما تبحث عنه:",
            "لحصول على نتائج أفضل، يمكنك تجربة:",
            "ربما تحتاج إلى تعديل بعض معايير البحث:"
        ];

        $options = [
            "توسيع نطاق البحث (إزالة بعض الفلاتر)",
            "البحث في مدينة أخرى",
            "تغيير نطاق السعر",
            "البحث عن ماركة مختلفة",
            "التحقق من توفر السيارات في وقت لاحق"
        ];

        $reply .= $suggestions[array_rand($suggestions)] . "\n";
        $reply .= "- " . implode("\n- ", array_slice($options, 0, 3));
        $reply .= "\n\nإذا كنت بحاجة إلى مساعدة إضافية، لا تتردد في سؤالي!";

        return response()->json([
            'reply' => $reply,
            'car_results' => [],
            'context' => $context,
            'suggestions' => [
                'توسيع نطاق البحث',
                'البحث في مدينة أخرى',
                'تغيير نوع السيارة'
            ],
            'contact_link' => "<a href='http://127.0.0.1:8000/dashboard#contact'>اتصل بالدعم الفني</a> إذا كنت بحاجة إلى مساعدة إضافية"
        ]);
    }

    private function handleResults($cars, $cityCode, $fuelType, $model, $brand, $priceRange, $features, $seats)
    {
        $count = $cars->count();
        
        $reply = "🚗 وجدت " . $count . " سيارة" . ($count > 1 ? "ات" : "") . " تطابق طلبك:\n\n";
    
        if ($cityCode) {
            $cityName = array_search($cityCode, $this->cities);
            $reply .= "- الموقع: " . $cityName . "\n";
        } else {
            $reply .= "- الموقع: جميع المدن\n";
        }
        
        if ($brand) {
            $reply .= "- الماركة: " . $brand . "\n";
        }
        if ($model) {
            $reply .= "- الموديل: " . $model . "\n";
        }
        if ($fuelType) {
            $fuelNames = [
                'petrol' => 'بنزين',
                'diesel' => 'ديزل',
                'electric' => 'كهربائية',
                'hybrid' => 'هجينة'
            ];
            $reply .= "- نوع الوقود: " . ($fuelNames[$fuelType] ?? $fuelType) . "\n";
        }
        if ($priceRange) {
            $pr = $priceRange;
            if (isset($pr['min']) && isset($pr['max'])) {
                $reply .= "- نطاق السعر: بين " . $pr['min'] . " و " . $pr['max'] . " دج يومياً\n";
            } elseif (isset($pr['min'])) {
                $reply .= "- نطاق السعر: أكثر من " . $pr['min'] . " دج يومياً\n";
            } elseif (isset($pr['max'])) {
                $reply .= "- نطاق السعر: أقل من " . $pr['max'] . " دج يومياً\n";
            }
        }
        
        if (!empty($features)) {
            $reply .= "- المميزات:\n";
            foreach ($features as $feature => $value) {
                switch ($feature) {
                    case 'family': 
                        $reply .= "  • مناسبة للعائلة\n";
                        break;
                    case 'child_seat': 
                        $reply .= "  • مقعد أطفال\n"; 
                        break;
                    case 'air_conditioning': 
                        $reply .= "  • تكييف هواء\n"; 
                        break;
                }
            }
        }
        
        if ($seats) {
            $reply .= "- عدد المقاعد: " . $seats . "+\n";
        }
    
        $reply .= "\nإليك بعض الخيارات المتاحة:";
    
        return response()->json([
            'reply' => $reply,
            'car_results' => $this->formatCarResults($cars),
            'context' => [
                'last_search' => [
                    'city' => $cityCode,
                    'fuel_type' => $fuelType,
                    'model' => $model,
                    'brand' => $brand,
                    'price_range' => $priceRange,
                    'features' => $features,
                    'seats' => $seats
                ]
            ],
            'suggestions' => [
                'عرض المزيد من التفاصيل',
                'حجز سيارة',
                'البحث بمعايير مختلفة'
            ],
            'contact_link' => "<a href='http://127.0.0.1:8000/dashboard#contact'>اتصل بنا</a> للحصول على مساعدة في الحجز"
        ]);
    }
    private function formatCarResults($cars)
    {
        $results = [];
        foreach ($cars as $car) {
            $features = [];
            if ($car->family_friendly) $features[] = 'مناسبة للعائلة';
            if ($car->child_seat) $features[] = 'مقعد أطفال';
            if ($car->air_conditioning) $features[] = 'تكييف هواء';
            
            $results[] = [
                'id' => $car->id,
                'brand' => $car->brand,
                'model' => $car->model,
                'year' => $car->year,
                'daily_rate' => number_format($car->daily_rate, 0),
                'weekly_rate' => number_format($car->daily_rate * 7 * 0.9, 0),
                'monthly_rate' => number_format($car->daily_rate * 30 * 0.8, 0),
                'city' => $car->agency->city,
                'fuel_type' => $this->translateFuelType($car->fuel_type),
                'seats' => $car->seats,
                'transmission' => $car->transmission == 'automatic' ? 'أوتوماتيك' : 'يدوي',
                'agency' => [
                    'name' => $car->agency->name,
                    'city' => $car->agency->city,
                    'address' => $car->agency->address,
                    'phone' => $car->agency->phone
                ],
                'status' => $car->bookings->isEmpty() ? 'متاحة' : 'محجوزة',
                'features' => $features,
                'image_url' => $car->image_url ?? 'default_car.jpg'
            ];
        }
        return $results;
    }
    private function translateFuelType($type)
    {
        $translations = [
            'petrol' => 'بنزين',
            'diesel' => 'ديزل',
            'electric' => 'كهربائية',
            'hybrid' => 'هجينة'
        ];
        return $translations[$type] ?? $type;
    }
}