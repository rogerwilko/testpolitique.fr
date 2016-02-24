<?php
        
        
        // calcul du score le plus à gauche d'un axe
        function calculMaxLeft($sa)
        {
            $max=0;
            
            // pour toutes les questions
            foreach($sa as $q)
            {
                $maxq=0;
                
                // pour toutes les réponses
                foreach($q[1] as $r)
                {
                    if($r[1] < $maxq)
                        $maxq=$r[1];
                }
                
                $max+=$maxq;
            }
            
            return $max;
        }
        
        
        // calcul du score le plus à droite d'un axe
        function calculMaxRight($sa)
        {
            $max=0;
            
            // pour toutes les questions
            foreach($sa as $q)
            {
                $maxq=0;
                
                // pour toutes les réponses
                foreach($q[1] as $r)
                {
                    if($r[1] > $maxq)
                        $maxq=$r[1];
                }
                
                $max+=$maxq;
            }
            
            return $max;
        }
        
        
        // calcul du score d'un axe en prenant sa position de début
        // dans le tableau de session
        function calculScore($sa, $debut)
        {
            $score=0;
            
            $posfin=$debut+count($sa)-1;
            $posinsa=0;
            
            for($pos=$debut;$pos<=$posfin;$pos++)
            {
                $idrep=$_GET["rad$pos"]; // numero de la réponse choisie
                
                if($idrep!=-1)
                {
                    $score+=$sa[$posinsa][1][$idrep][1];
                    //echo "$posinsa $idrep<br />";
                }
                
                $posinsa++;
            }
            
            return $score;
        }
        
        
        // génération d'un graphique pour un axe
        function generateGraph($min, $max, $pos, $inflg=null, $infld=null)
        {
            $ech=50;
            
            $newpos=0;
            
            if($pos<0)
                $newpos=round(-$pos/$min*$ech);
            
            if($pos>0)
                $newpos=round($pos/$max*$ech);
            
            
            $ret="<div class='descr'><span class='graph'>|-";
            
            // flags pour colorier la zone d'influence des partis
            $minpasse=0;
            $maxpasse=0;
            
            for($i=-$ech;$i<=$ech;$i++)
            {
                
                if($i==$newpos)
                    $ret.="<span class='imhere'>O</span>";
                
                else if($i!=0)
                {
                    $pc=$i*100/$ech;
                    
                    /*if($inflg!=null && ($pc >= ($pos - $inflg)) && ($pc <= ($pos + $infld)))
                        $ret.="<span class='infl'>-</span>";*/
                    
                    if($inflg!=null && ($pc >= ($pos - $inflg)) && $minpasse==0)
                    {
                        $minpasse=1;
                        $ret.="<span class='infl'>";
                    }

                    $ret.="-";
                    
                    if($inflg!=null && $pc >= ($pos + $infld) && $maxpasse==0)
                    {
                        $maxpasse=1;
                        $ret.="</span>";
                    }
  
                }
                
                else
                    $ret.=".";
            }
            
            $ret.='-|</span></div>';
            
            return $ret;
        }
        
        
        
        function pourcent($score, $min, $max)
        {
            $res=0;
            
            if($score<0)
                $res=round(-$score/$min*100);
            
            if($score>0)
                $res=round($score/$max*100);
            
            return $res;
        }
        
        
        // calcul du taux de proximité avec les partis
        function calculParti()
        {
            global $partis;
            global $coco,$decentr,$educ,$hiera, $lib, $just, $eco, $imi, $demo;
            
            $res=array();
            
            foreach($partis as $p)
            {
                $taux=0;
                $tauxmax=0;
                
                foreach($p as $n => $cond)
                {
                    if($cond!=null)
                    {
                        //echo("$n => $cond<br />");
                        
                        // on récupère le tableau et l'adresse de début correspondant à la condition
                       
                        $tab=array();
                        $debut=0;
                        
                        
                        if($n=="coco")
                        {
                            $tab=$coco;
                            $debut=0;
                        }
                        
                        else if($n=="decentr")
                        {
                            $tab=$decentr;
                            $debut=count($coco);
                        }
                        
                        else if($n=="educ")
                        {
                            $tab=$educ;
                            $debut=count(array_merge($coco,$decentr));
                        }
                        
                        
                        else if($n=="hiera")
                        {
                            $tab=$hiera;
                            $debut=count(array_merge($coco,$decentr,$educ));
                        }
                        
                        else if($n=="libindiv")
                        {
                            $tab=$lib;
                            $debut=count(array_merge($coco,$decentr,$educ,$hiera));
                        }
                        
                        else if($n=="justice")
                        {
                            $tab=$just;
                            $debut=count(array_merge($coco,$decentr,$educ,$hiera, $lib));
                        }
                        
                        
                        else if($n=="ecolo")
                        {
                            $tab=$eco;
                            $debut=count(array_merge($coco,$decentr,$educ,$hiera, $lib, $just));
                        }
                        
                        else if($n=="inter")
                        {
                            $tab=$imi;
                            $debut=count(array_merge($coco,$decentr,$educ,$hiera, $lib, $just, $eco));
                        }
                        
                        else if($n=="demo")
                        {
                            $tab=$demo;
                            $debut=count(array_merge($coco,$decentr,$educ,$hiera, $lib, $just, $eco, $imi));
                        }
                        
                        
                        else if($n=="axeeco")
                        {
                            $tab=array_merge($coco,$decentr,$educ);
                            $debut=0;
                        }
                        
                        else if($n=="axelib")
                        {
                            $tab=array_merge($hiera,$lib,$just);
                            $debut=count(array_merge($coco,$decentr,$educ));
                        }
                        
                        else if($n=="axesoc")
                        {
                            $tab=array_merge($eco,$imi,$demo);
                            $debut=count(array_merge($coco,$decentr,$educ,$hiera, $lib, $just));
                        }
                        
                        
                        else
                        {
                            continue;
                        }
                        
                        // score requis
                        
                        $requis=$cond[0];
                        $minrequis=$requis-$cond[1];
                        $maxrequis=$requis+$cond[2];
                        
                        $tauxmax+=100;
                        
                        
                        // calcul du pourcentage réalisé par l'utilisateur
                        
                        $min=calculMaxLeft($tab);
                        $max=calculMaxRight($tab);
                        $score=calculScore($tab, $debut);
                        
                        $newscore=pourcent($score, $min, $max);
                        
                        
                        //echo("nom : $n ; cond : $cond ; requis : $requis ; minrequis : $minrequis ; maxrequis : $maxrequis<br />");
                        //echo("min : $min ; max : $max ; score : $score ; newscore : $newscore%<br /><br />");
                        
                        
                        if($minrequis <= $newscore && $maxrequis >= $newscore)
                        {
                            $taux+=65; // on est dedans : la majorité des points
                        }
                        
                        else
                        {
                            $minrequis=-100;
                            $maxrequis=100;
                        }
                            
                            // on ajoute le reste des points selon la proximité avec le score parfait

                            $diff=abs($newscore - $requis);
                            $bigdiff=abs($minrequis - $maxrequis);
                                
                            $pcdiff=(1-($diff/$bigdiff))*35;
                                
                            $taux+=$pcdiff;

                            
                            //echo("DIFF : $diff ; $bigdiff ; $pcdiff ; ");

                    }
                }
                
                //$res[$p["nom"]]=$taux/$tauxmax*100;
                //if(($taux/$tauxmax*100)>60)
                    $res[]=array(round($taux/$tauxmax*100),$p);
                
                //echo("Taux pour ".$p["nom"]." : ".($taux/$tauxmax*100)."<br /><br />");
            }
            
            return $res;
        }
        
        
        // récupération des trois meilleus partis
        function getMeilleursPartis($p)
        {
            $res=array();
            
            $mp=$p;
            
            sort($mp); // tri
            $mp=array_reverse($mp); // inversion du tableau trié
            
            $s=count($mp);
            
            if($s>0)
                $res[]=$mp[0];
            if($s>1)
                $res[]=$mp[1];
            if($s>2)
                $res[]=$mp[2];
            
            //return $mp;
            return $res;
        }
        
?>
