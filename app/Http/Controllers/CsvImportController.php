<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \SplFileObject;
use \DateTime;
use \Exception;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CsvImportController extends Controller
{
    public function tournament_csv(Request $request){
        if($request->hasFile('csv') && $request->file('csv')->isValid()){
            try{

            } catch (Exception $ex){
                return redirect('/importcsv/tournament')
                    ->with('message', '正しいcsvのformatを選んでください');
            }
            try{
                setlocale(LC_ALL, 'ja_JP.UTF-8');
                $file_path = $request->file('csv')->path();
                $file = new \SplFileObject($file_path);
                $file->setFlags(
                    SplFileObject::READ_CSV |
                    SplFileObject::READ_AHEAD |
                    SplFileObject::SKIP_EMPTY
                );
                $i = 0;
                while (!$file->eof()) {
                    $i++;
                    $file->next();
                }

                $count = 1;
                foreach ($file as $row){
                    $id = intval($row[0]);
                    $name = $row[1];
                    $start = $row[2];
                    $date = new DateTime($start);
                    $year = $row[3];
                    $country = $row[4];
                    DB::table('wc_tournament')
                        ->insert(
                            ['id' => $id,'name' => $name,'start_date' => $date->format('Y-m-d'),'year' => $year,'country' => $country]
                        );
                    $count++;
                }
                return redirect('/importcsv/select_csv')
                    ->with('message', '登録成功');

            } catch (Exception $ex){
                return redirect('/importcsv/tournament')
                    ->with('message', '正しいformatを選んでください');
            }
        }
        return redirect('/importcsv/tournament')
                    ->with('message', 'fileを選択してください');
    }

    public function round_csv(Request $request){
        if($request->hasFile('csv') && $request->file('csv')->isValid()){
            try{
                setlocale(LC_ALL, 'ja_JP.UTF-8');
                $file_path = $request->file('csv')->path();
                $file = new \SplFileObject($file_path);
                $file->setFlags(
                    SplFileObject::READ_CSV |
                    SplFileObject::READ_AHEAD |
                    SplFileObject::SKIP_EMPTY
                );
                $i = 0;
                while (!$file->eof()) {
                    $i++;
                    $file->next();
                }
                $count = 1;
                foreach ($file as $row){

                        $id = intval($row[0]);
                        $tournament = intval($row[1]);
                        $name = $row[2];
                        $ordering = intval($row[3]);
                        $knockout = intval($row[4]);
                        $startdate = new DateTime(($row[5]));
                        $enddate = new DateTime(($row[6]));
                        DB::table('wc_round')
                        ->insert(
                            ['id' => $id,'tournament_id' => $tournament,'name' => $name,'ordering' => $ordering,'knockout' => $knockout,'start_date' => $startdate->format('Y-m-d'),'end_date' => $enddate->format('Y-m-d')]
                        );
                    
                    $count++;
                }
                return redirect('/importcsv/select_csv')
                    ->with('message', '登録成功');
            } catch (Exception $ex){
                return redirect('/importcsv/round')
                    ->with('message', '正しいcsvのformatを選んでください');
            }
        }
        return redirect('/importcsv/round')
                    ->with('message', 'fileを選択してください');
    }

    public function match_csv(Request $request){
        if($request->hasFile('csv') && $request->file('csv')->isValid()){
            try{
                setlocale(LC_ALL, 'ja_JP.UTF-8');
                $file_path = $request->file('csv')->path();
                $file = new \SplFileObject($file_path);
                $file->setFlags(
                    SplFileObject::READ_CSV |
                    SplFileObject::READ_AHEAD |
                    SplFileObject::SKIP_EMPTY
                );
                $i = 0;
                while (!$file->eof()) {
                    $i++;
                    $file->next();
                }
                $count = 1;
                foreach ($file as $row){
                    $id = intval($row[0]);
                    $round = intval($row[1]);
                    $group = intval($row[2]);
                    $startdate = $row[3];
                    $ordering = intval($row[4]);
                    $knockout = intval($row[5]);
                    DB::table('wc_match')
                        ->insert(
                            ['id' => $id,'round_id' => $round,'group_id' => $group,'start_date' => date('Y-m-d H:i',strtotime($startdate)),'ordering' => $ordering,'knockout' => $knockout]
                        );
                    $count++;
                }
                return redirect('/importcsv/select_csv')
                    ->with('message', '登録成功');
            } catch (Exception $ex){
                return redirect('/importcsv/match')
                    ->with('message', '正しいcsvのformatを選んでください');
            }
        }
        return redirect('/importcsv/match')
                    ->with('message', 'fileを選択してください');
    }
    public function group_csv(Request $request){
        if($request->hasFile('csv') && $request->file('csv')->isValid()){
            try{
                setlocale(LC_ALL, 'ja_JP.UTF-8');
                $file_path = $request->file('csv')->path();
                $file = new \SplFileObject($file_path);
                $file->setFlags(
                    SplFileObject::READ_CSV |
                    SplFileObject::READ_AHEAD |
                    SplFileObject::SKIP_EMPTY
                );
                $i = 0;
                while (!$file->eof()) {
                    $i++;
                    $file->next();
                }
                $count = 1;
                foreach ($file as $row){

                        $id = intval($row[0]);
                        $name = $row[1];
                        $ordering = intval($row[2]);
                        DB::table('wc_group')
                        ->insert(
                            ['id' => $id,'name' => $name,'ordering' => $ordering]
                        );
                    
                    $count++;
                }
                return redirect('/importcsv/select_csv')
                    ->with('message', '登録成功');
            } catch (Exception $ex){
                return redirect('/importcsv/group')
                    ->with('message', '正しいcsvのformatを選んでください');
            }
        }
        return redirect('/importcsv/group')
                    ->with('message', 'fileを選択してください');
    }

    public function result_csv(Request $request){
        if($request->hasFile('csv') && $request->file('csv')->isValid()){
            try{
                setlocale(LC_ALL, 'ja_JP.UTF-8');
                $file_path = $request->file('csv')->path();
                $file = new \SplFileObject($file_path);
                $file->setFlags(
                    SplFileObject::READ_CSV |
                    SplFileObject::READ_AHEAD |
                    SplFileObject::SKIP_EMPTY
                );
                $i = 0;
                while (!$file->eof()) {
                    $i++;
                    $file->next();
                }
                $count = 1;
                foreach ($file as $row){
                    $id = intval($row[0]);
                    $match_id = intval($row[1]);
                    $team_id0 = intval($row[2]);
                    $team_id1 = intval($row[3]);
                    $rs = intval($row[4]);
                    $rs_extra = intval($row[5]);
                    $rs_pk = intval($row[6]);
                    $ra = intval($row[7]);
                    $ra_extra = intval($row[8]);
                    $ra_pk = intval($row[9]);
                    $difference = intval($row[10]);
                    $outcome = $row[11];
                    $count_win = intval($row[12]);
                    $count_lose = intval($row[13]);
                    $count_stilmate = intval($row[14]);
                    $point = intval($row[14]);
                    $extra = intval($row[14]);
                    $pk = intval($row[14]);
                    $duplicate = $row[14];

                    $ordering = intval($row[2]);
                    DB::table('wc_result')
                        ->insert(
                            ['id' => $id,'match_id' => $match_id,'team_id0' => $team_id0,'team_id1' => $team_id1,'rs' => $rs,'rs_extra' => $rs_extra,'rs_pk' => $rs_pk,
                            'ra' => $ra,'ra_extra' => $ra_extra,'ra_pk' => $ra_pk,'difference' => $difference,'outcome' => $outcome,'count_win' => $count_win,'count_lose' => $count_lose,
                            'count_stillmate' => $count_stilmate,'point' => $point,'extra' => $extra,'pk' => $pk,'duplicate' => $duplicate]
                        );
                    $count++;
                }
                return redirect('/importcsv/select_csv')
                    ->with('message', '登録成功');
            } catch (Exception $ex){
                return redirect('/importcsv/result')
                    ->with('message', '正しいcsvのformatを選んでください');
            }
        }
        return redirect('/importcsv/result')
                    ->with('message', 'fileを選択してください');
    }

    public function team_csv(Request $request){      
        if($request->hasFile('csv') && $request->file('csv')->isValid()){
            try{
                setlocale(LC_ALL, 'ja_JP.UTF-8');
                $file_path = $request->file('csv')->path();
                $file = new \SplFileObject($file_path);
                $file->setFlags(
                    SplFileObject::READ_CSV |
                    SplFileObject::READ_AHEAD |
                    SplFileObject::SKIP_EMPTY
                );
                $i = 0;
                while (!$file->eof()) {
                    $i++;
                    $file->next();
                }
                $count = 1;
                foreach ($file as $row){
                    $id = intval($row[0]);
                    $name = $row[1];
                    $country = $row[2];
                    $country_now = $row[3];
                    $area = $row[4];
                    $lat= floatval($row[5]);
                    $lng = floatval($row[6]);
                    DB::table('wc_team')
                        ->insert(
                            ['id' => $id,'name' => $name,'country' => $country,'country_now' => $country_now,'area' => $area,'lat' => $lat,'lng' => $lng]
                        );
                    $count++;
                }
                return redirect('/importcsv/select_csv')
                    ->with('message', '登録成功');
            } catch (Exception $ex){
                return redirect('/importcsv/team')
                    ->with('message', '正しいcsvのformatを選んでください');
            }
        }
        return redirect('/importcsv/team')
                    ->with('message', 'fileを選択してください');
    }
    //
}
