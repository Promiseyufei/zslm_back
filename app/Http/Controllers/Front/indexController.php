<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/11/23
     * Time: 8:24
     */
    
    namespace App\Http\Controllers\Front;
    
    
    use App\Http\Controllers\Controller;
    use App\Http\Controllers\Front\Activity\ActivityController;
    use App\Http\Controllers\Front\Coach\CoachController;
    use App\Http\Controllers\Front\Colleges\MajorController;
    use App\Http\Controllers\Front\Consult\ConsultController;
    use Symfony\Component\HttpFoundation\Request;

    class indexController extends Controller
    {
        
        public function getIndexInfo(Request $request){
            
            if(!$request->isMethod('get'))
                return responseToJson(1,"请求错误");
            $major = new MajorController();
            $majors = $major->getMajorToIndex('');
            $coach = new CoachController();
            $coachs = $coach->getIndexInfo('');
          
            $consult = new ConsultController();
            $consults = $consult->getIndexConsult(1,6);
           
            $acitve = new ActivityController();
          
            $actives = $acitve->getIndexActivity($request,1,3);
            dd($actives);
                return responseToJson(0,'success',['major'=>$majors,'coach'=>$coachs,'consult'=>$consults,'actives'=>$actives]);
        }
        
    }