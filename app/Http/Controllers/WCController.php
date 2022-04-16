<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Illuminate\Http\Request;

class WCController extends Controller
{
    public function search()
    {
        DB::enableQueryLog();

        $options = [];
        $tournament_results = DB::table('wc_tournament')
            ->select('id', 'name')
            ->get();
        $round_results = DB::table('wc_round')
            ->select('name')
            ->groupBy('name')
            ->get();
        $group_results = DB::table('wc_group')
            ->select('ordering','name')
            ->distinct()
            ->get();
        $team_results = DB::table('wc_team')
            ->select('id', 'country')
            ->get();
        return view('ui/search', [
            'tournaments' => $tournament_results,
            'rounds' => $round_results,
            'groups' => $group_results,
            'teams' => $team_results
        ]);
    }

    public function searchResults()
    {
        $tournament_id = request('tournament');
        $round_name = request('round');
        $group_name = request('group');
        $team_id = request('team');
        $win = request('win');
        $lose = request('lose');
        $drow = request('drow');
        $data1 = DB::table("wc_tournament as wt")
            ->join('wc_round as wround', 'wround.tournament_id','=','wt.id')
            ->join('wc_match as wm', 'wm.round_id','=','wround.id')
            ->join('wc_group as wg', 'wg.id','=','wm.group_id')
            ->join('wc_result as wr', 'wr.match_id','=','wm.id')
            ->join('wc_team as wte0', 'wte0.id','=','wr.team_id0')
            ->join('wc_team as wte1', 'wte1.id','=','wr.team_id1')
            ->select('wt.name as name1', 'wround.name as name2','wg.name as name3','wround.start_date','wte0.country as country1','wr.rs as plus','wr.ra as mina','wte1.country as country2','wte0.id as id1','wte1.id as id2')
            ->when($tournament_id, function($query) use ($tournament_id){
                return $query->where('wt.id', $tournament_id);
            })
            ->when($round_name, function($query) use ($round_name){
                if($round_name == 'group'){
                    return $query->where('wg.ordering', '<>','0');
                } else {
                    return $query->where('wg.ordering', '=','0');
                }
            })
            ->when($group_name, function($query) use ($group_name){
                return $query->where('wg.ordering', $group_name);
            })
            ->when($team_id, function($query) use ($win,$lose,$drow,$team_id){
                return $query->where(function($query)use ($win,$lose,$drow,$team_id){
                    return $query->where(function($query)use ($win,$team_id){
                        return $query->when($win, function($query) use ($team_id){
                            return $query->where(function($query)use ($team_id){
                                return  $query->where('wr.count_win', 1)
                                    ->where('wte0.id', $team_id);
                            })
                            ->orWhere(function($query)use ($team_id){
                                return  $query->where('wr.count_lose', 1)
                                    ->where('wte1.id', $team_id);
                            });
                        });
                    })
                    ->orWhere(function($query)use ($lose,$team_id){
                        return $query->when($lose, function($query) use ($team_id){
                            return $query->where(function($query)use ($team_id){
                                return  $query->where('wr.count_lose', 1)
                                    ->where('wte0.id', $team_id);
                            })
                            ->orWhere(function($query)use ($team_id){
                                return  $query->where('wr.count_win', 1)
                                    ->where('wte1.id', $team_id);
                            });
                        });
                    })
                    ->orWhere(function($query)use ($drow,$team_id){
                        return $query->when($drow, function($query) use ($team_id){
                            return $query->where(function($query)use ($team_id){
                                return  $query->where('wr.count_stillmate', 1)
                                    ->where('wte0.id', $team_id);
                            })
                            ->orWhere(function($query)use ($team_id){
                                return  $query->where('wr.count_stillmate', 1)
                                    ->where('wte1.id', $team_id);
                            });
                        });
                    });
                });
            })
            ->when($team_id, function($query) use ($team_id){
                return $query->where(function($query)use ($team_id){
                    return $query->where('wte1.id', $team_id)
                    ->orWhere('wte0.id', $team_id);
                });
            })
            ->get();

        $latlng0 = DB::table("wc_tournament as wt")
            ->join('wc_round as wround', 'wround.tournament_id','=','wt.id')
            ->join('wc_match as wm', 'wm.round_id','=','wround.id')
            ->join('wc_group as wg', 'wg.id','=','wm.group_id')
            ->join('wc_result as wr', 'wr.match_id','=','wm.id')
            ->join('wc_team as wte0', 'wte0.id','=','wr.team_id0')
            ->join('wc_team as wte1', 'wte1.id','=','wr.team_id1')
            ->select('wte1.id as id','wte1.lat as lat','wte1.lng as lng','wte1.country as name')
            ->when($tournament_id, function($query) use ($tournament_id){
                return $query->where('wt.id', $tournament_id);
            })
            ->when($round_name, function($query) use ($round_name){
                if($round_name == 'group'){
                    return $query->where('wg.ordering', '<>','0');
                } else {
                    return $query->where('wg.ordering', '=','0');
                }
            })
            ->when($group_name, function($query) use ($group_name){
                return $query->where('wg.ordering', $group_name);
            })
            ->when($team_id, function($query) use ($win,$lose,$drow,$team_id){
                return $query->where(function($query)use ($win,$lose,$drow,$team_id){
                    return $query->where(function($query)use ($win,$team_id){
                        return $query->when($win, function($query) use ($team_id){
                            return $query->where(function($query)use ($team_id){
                                return  $query->where('wr.count_win', 1)
                                    ->where('wte0.id', $team_id);
                            });
                        });
                    })
                    ->orWhere(function($query)use ($lose,$team_id){
                        return $query->when($lose, function($query) use ($team_id){
                            return $query->where(function($query)use ($team_id){
                                return  $query->where('wr.count_lose', 1)
                                    ->where('wte0.id', $team_id);
                            });
                        });
                    })
                    ->orWhere(function($query)use ($drow,$team_id){
                        return $query->when($drow, function($query) use ($team_id){
                            return $query->where(function($query)use ($team_id){
                                return  $query->where('wr.count_stillmate', 1)
                                    ->where('wte0.id', $team_id);
                            });
                        });
                    });
                });
            })
            ->when($team_id, function($query) use ($team_id){
                return $query->where(function($query)use ($team_id){
                    return $query->Where('wte0.id', $team_id);
                });
            });

        $latlng1 = DB::table("wc_team as wt")
            ->select('wt.id as id','wt.lat as lat','wt.lng as lng','wt.country as name')
            ->where('wt.id',$team_id);
        
        $latlng = DB::table("wc_tournament as wt")
            ->join('wc_round as wround', 'wround.tournament_id','=','wt.id')
            ->join('wc_match as wm', 'wm.round_id','=','wround.id')
            ->join('wc_group as wg', 'wg.id','=','wm.group_id')
            ->join('wc_result as wr', 'wr.match_id','=','wm.id')
            ->join('wc_team as wte0', 'wte0.id','=','wr.team_id0')
            ->join('wc_team as wte1', 'wte1.id','=','wr.team_id1')
            ->select('wte0.id as id','wte0.lat as lat','wte0.lng as lng','wte0.country as name')
            ->when($tournament_id, function($query) use ($tournament_id){
                return $query->where('wt.id', $tournament_id);
            })
            ->when($round_name, function($query) use ($round_name){
                if($round_name == 'group'){
                    return $query->where('wg.ordering', '<>','0');
                } else {
                    return $query->where('wg.ordering', '=','0');
                }
            })
            ->when($group_name, function($query) use ($group_name){
                return $query->where('wg.ordering', $group_name);
            })
            ->when($team_id, function($query) use ($win,$lose,$drow,$team_id){
                return $query->where(function($query)use ($win,$lose,$drow,$team_id){
                    return $query->where(function($query)use ($win,$team_id){
                        return $query->when($win, function($query) use ($team_id){
                            return $query
                            ->where(function($query)use ($team_id){
                                return  $query->where('wr.count_lose', 1)
                                    ->where('wte1.id', $team_id);
                            });
                        });
                    })
                    ->orWhere(function($query)use ($lose,$team_id){
                        return $query->when($lose, function($query) use ($team_id){
                            return $query
                            ->where(function($query)use ($team_id){
                                return  $query->where('wr.count_win', 1)
                                    ->where('wte1.id', $team_id);
                            });
                        });
                    })
                    ->orWhere(function($query)use ($drow,$team_id){
                        return $query->when($drow, function($query) use ($team_id){
                            return $query
                            ->where(function($query)use ($team_id){
                                return  $query->where('wr.count_stillmate', 1)
                                    ->where('wte1.id', $team_id);
                            });
                        });
                    });
                });
            })
            ->when($team_id, function($query) use ($team_id){
                return $query->where(function($query)use ($team_id){
                    return $query->where('wte1.id', $team_id);
                });
            })
            ->union($latlng0)
            ->union($latlng1)
            ->distinct()
            ->get();

        return view('ui/search_win_results', [
            'data1' => $data1,
            'latlng' => $latlng
        ]);
    }
    public function searchTeams(Request $req){
        $id = $req->query('id');
        $data1 = DB::table("wc_tournament as wt")
        ->join('wc_round as wround', 'wround.tournament_id','=','wt.id')
        ->join('wc_match as wm', 'wm.round_id','=','wround.id')
        ->join('wc_group as wg', 'wg.id','=','wm.group_id')
        ->join('wc_result as wr', 'wr.match_id','=','wm.id')
        ->join('wc_team as wte0', 'wte0.id','=','wr.team_id0')
        ->join('wc_team as wte1', 'wte1.id','=','wr.team_id1')
        ->select('wte0.id as id','wte0.country as name')
        ->where('wt.id',$id)
        ->distinct();

        $data = DB::table("wc_tournament as wt")
        ->join('wc_round as wround', 'wround.tournament_id','=','wt.id')
        ->join('wc_match as wm', 'wm.round_id','=','wround.id')
        ->join('wc_group as wg', 'wg.id','=','wm.group_id')
        ->join('wc_result as wr', 'wr.match_id','=','wm.id')
        ->join('wc_team as wte0', 'wte0.id','=','wr.team_id0')
        ->join('wc_team as wte1', 'wte1.id','=','wr.team_id1')
        ->select('wte1.id as id','wte1.country as name')
        ->where('wt.id',$id)
        ->union($data1)
        ->distinct()
        ->get();
        return json_encode($data);
    }

    public function searchGroup(Request $req){
        $id = intval($req->query('id'));
        $round_name = $req->query('round_name');
        if($round_name == 'group'){
            $data = DB::table("wc_tournament as wt")
            ->join('wc_round as wround', 'wround.tournament_id','=','wt.id')
            ->join('wc_match as wm', 'wm.round_id','=','wround.id')
            ->join('wc_group as wg', 'wg.id','=','wm.group_id')
            ->join('wc_result as wr', 'wr.match_id','=','wm.id')
            ->join('wc_team as wte0', 'wte0.id','=','wr.team_id0')
            ->join('wc_team as wte1', 'wte1.id','=','wr.team_id1')
            ->select('wg.ordering as id','wg.name as name')
            ->when($id, function($query) use ($round_name,$id){
                if($round_name == 'group'){
                    return $query->where('wt.id',$id);
                } else {
                    return $query->where('wg.ordering', '=','0');
                }
            })
            ->distinct()
            ->orderBy('id', 'asc')
            ->get();
            return json_encode($data);
        } else if($round_name == 'knock'){
            $data = DB::table("wc_tournament as wt")
            ->join('wc_round as wround', 'wround.tournament_id','=','wt.id')
            ->join('wc_match as wm', 'wm.round_id','=','wround.id')
            ->join('wc_group as wg', 'wg.id','=','wm.group_id')
            ->join('wc_result as wr', 'wr.match_id','=','wm.id')
            ->join('wc_team as wte0', 'wte0.id','=','wr.team_id0')
            ->join('wc_team as wte1', 'wte1.id','=','wr.team_id1')
            ->select('wg.ordering as id','wround.name as name')
            ->when($id, function($query) use ($round_name,$id){
                return $query->where('wt.id',$id)
                    ->where('wround.knockout',1);
            })
            ->distinct()
            ->orderBy('id', 'asc')
            ->get();
            return json_encode($data);
        }
        
    }
}
