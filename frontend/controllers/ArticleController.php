<?php
namespace frontend\controllers;

use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;

class ArticleController extends BaseAPIController {
    public function behaviors() {
        $behaviors = parent::behaviors();
        if (Yii::$app->getRequest()->getMethod() !== 'OPTIONS') {
            $behaviors['authenticator'] = [
                'class' => HttpBearerAuth::className(),
            ];
        }

        return ArrayHelper::merge([
            [
                'class' => Cors::className(),
                'cors' => [
                    'Origin' => ['http://localhost:9528', 'http://qingtingtui.com'],
                    'Access-Control-Request-Method' => ['GET', 'HEAD', 'OPTIONS'],
                ],
            ],
        ], $behaviors);
    }

    public function actionList() {
        $a = '[
  {
    "title": "加构非先采状给细书率感压极将。",
    "content": "个因将任革半术将儿因比原则车处小。别八学调表需安声复记江划研作日难。路将式小十知这道车例响本号府单。员亲十体把周资治往回比何关本条。习见门由习物最见何位资么二段十派。必必山提教万进深和流须号五况细。思必准元得易明到后研布则重代组律之。",
    "url": "telnet://vtwkfvtii.ao/gee",
    "photo": "http://dummyimage.com/200x200"
  },
  {
    "title": "它难电他况出认划标才具收打点。",
    "content": "近命大按党走两马派断世拉质转没条。江于及济斯无极还程级布土感体。数动等部说手起门部重志度。九广们铁及带叫什己强力质世整参几美一。商风家月直维次验们东低高市已。",
    "url": "http://dqtmi.cx/yxfsavygs",
    "photo": "http://dummyimage.com/200x200"
  },
  {
    "title": "日品动生想油理制么原白文习小世。",
    "content": "问才持广业己元合走段亲车严而认马际。基将段又见导支越太达在节八中员。特近照强议一任况时次能了阶七将往越。想里表而他金增料电调率她。济自起报提段理响根我压认高清严时共。新取非名改许也年低压水山增九格无。",
    "url": "telnet://iykrnidun.sy/nttusoyb",
    "photo": "http://dummyimage.com/200x200"
  },
  {
    "title": "团导日采家其局回小内军研八统约听。",
    "content": "身感参办点料被本基少外料技。此成确众我上教前制政矿团选满。完题高动四持得程具连日见等其米农难。后实争我常住油改提农义观设明至是。日效理多信越自百看究任手务全。他者治消下才素商电机以世出就主说石。影提说部入压认团小布之分电完眼。",
    "url": "cid://bbbp.ca/pocxl",
    "photo": "http://dummyimage.com/200x200"
  },
  {
    "title": "精各元当带形流温命了一此此。",
    "content": "自易年主全准导示少界门前低点相确派。采都干复采月院手流会拉越委少进战采。称话任引持复名但验济走重接太分。族根今元必从收叫出学义日色证各。集合万电专写治机大条马存低。",
    "url": "cid://nrhn.zr/kjdc",
    "photo": "http://dummyimage.com/200x200"
  },
  {
    "title": "状上团用养内按及再该京程最决。",
    "content": "白众表四根着们几界消或较关适。包证火她强同义温书活什响展党准群。属图又本特看提给造很权收两该文程。来接结交如根际从军出至程先整南。然没己一计带院名特多转生已选么周满。造调号王使须来来外见料而万。",
    "url": "rlogin://nbyljfkbk.bi/zvgtlxn",
    "photo": "http://dummyimage.com/200x200"
  },
  {
    "title": "对育身安农办派新选性海求金深表。",
    "content": "就她指领题期到必保建直节示江。具物省提或京流周写热政长三我接至维太。将属时京领根除积外常水着应。据今算权安们况没外平然计确光并。和世几段力支划道导将该她儿省法领属。由要系造火代设用争结查先品接图用的。",
    "url": "ftp://bhepq.sm/lmtyhara",
    "photo": "http://dummyimage.com/200x200"
  },
  {
    "title": "族按候开专严料县果别各写结。",
    "content": "数外标在者共个就构任段任机只时。温定半但系料极商志与音电去子利。反理进严党山指格石电从收月。层利看知权线引场要放同被界长。地个报须社电今亲正边知加。引合离广九或文引风由才角济西养商。此定记面保断整往积社会深话情热报。",
    "url": "rlogin://bsfmm.np/mhkue",
    "photo": "http://dummyimage.com/200x200"
  },
  {
    "title": "其以采精文线公步处你取论声近与命织。",
    "content": "方区治业专事产复四路外省想边划产。接接节常图真经历会放存这从争示。龙根价系传将就题放空知再更。石别两决红值转就空下军至影。完七委率金世她交市记许定机响标节。",
    "url": "rlogin://olipjt.lb/qbwfjoek",
    "photo": "http://dummyimage.com/200x200"
  },
  {
    "title": "即象被听公东七民叫状式清。",
    "content": "石海本那已流想手得清除片低业。果转民力县战着什术张连值直空过农标。速据正头社身别织了工强拉日革。国委造器三影离面直选用难养具十音。美了给把断面究千七报温江群科七取。",
    "url": "cid://hns.ky/lhl",
    "photo": "http://dummyimage.com/200x200"
  },
  {
    "title": "委越来真属但质律元住接劳集根至千被。",
    "content": "志边县土果是场规示值律论省专六合或科。酸采状该五你走强党场斯干带。适亲带基四任对离系由看认权深即委。效红油不据压运美选志条准般命装。教物结们约就品积设识政用角油十。去候技文效办极识题江是并三时里于集。集直近容委处周派月一分指调流务社。",
    "url": "telnet://lcfdfdwbw.ae/uccoit",
    "photo": "http://dummyimage.com/200x200"
  },
  {
    "title": "展交证元期色管团代而本个收安影积指。",
    "content": "力团政素结变人龙也那联流识本从几。一党科增形农领式清入象面。加金路世线才联不青众习天斗认毛力给。变当十满还老真规头家适离市太。",
    "url": "mid://vdbu.tw/yohrtlc",
    "photo": "http://dummyimage.com/200x200"
  },
  {
    "title": "省少题原战验内离命为半系处会适系。",
    "content": "通法它着最增油没风组许离拉。生号最东点见选称需团车须理土目调就。定化需会论织往此社省己二复海。究青情列么就级叫期比权么近来经务段。大市律军场空外带的单江看美照安马。",
    "url": "gopher://xmoqtyjs.kr/zyhajn",
    "photo": "http://dummyimage.com/200x200"
  }
]';
        return ['success' => 0, 'msg' => '', 'data' => json_decode($a, true)];
    }
}
