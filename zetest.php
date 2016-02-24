<?php
    include("header.php");
    
    include("questions.php");
    
    include("partis.php");
?>



<script type="text/javascript" >


            
            if (window.addEventListener){
              window.addEventListener('load', init, false);
            }
            
             else {
              //window.attachEvent('load', init);
              window.onload=init; // ie sux
            }

        //window.addEventListener("load", init, false);


        /*
                Fonction d'initialisation du script.
        */
        function init()
        {

            if (window.addEventListener){
              document.getElementById("bsub").addEventListener('click', gogogo, false);
            }
            
            else {
              document.getElementById("bsub").attachEvent('onclick', gogogo);
            }

            
            //document.getElementById("bsub").addEventListener("click",gogogo,false);
        }


        function gogogo()
        {
            //new Effect.Opacity('zetest',{ duration: 1, from: 1, to: 0, afterFinish: function() { document.zetest.submit(); } });

            document.zetest.submit();
        }



        /*function goAJAX()
        {
                        new Ajax.Request('lolilol.php', {
                        method: 'get', 

                        onFailure: function(transport) { err("Erreur lors de la requÃªte AJAX !"); }, 
                        onSuccess: function(transport){
                        var heure = transport.responseText || "no response text";
                        ajoutPost(heure);
                }
                 });
        }*/

</script>



<br />


        
    <?php
    

    
        function writeResult($title, $descr, $axe, $tab, $pos)
        {
            $left=calculMaxLeft($tab);
            $right=calculMaxRight($tab);
            $score=calculScore($tab,$pos);
            
            // score global : on utilise les pourcentages plutôt que les points
            if($title=="Attention :")
            {
                $left=0;
                $right=0;
                $score=0;
                
                global $coco,$decentr,$educ,$hiera,$lib,$just,$eco,$imi,$demo;
                
                $tabtab=array($coco,$decentr,$educ,$hiera,$lib,$just,$eco,$imi,$demo);
                $pos=0;
                
                foreach($tabtab as $n => $t)
                {
                    $ml=calculMaxLeft($t);
                    $mr=calculMaxRight($t);
                    $s=calculScore($t, $pos);
  
                    $left+=pourcent($ml,$ml,$mr);
                    $right+=pourcent($mr,$ml,$mr);
                    $score+=pourcent($s,$ml,$mr);
                    //echo("ajout de ($s $ml $mr) ".pourcent($s,$ml,$mr)."<br />");
                    
                    // coef 2 pour l'axe économie
                    if($n < 3)
                    {
                        $left+=pourcent($ml,$ml,$mr);
                        $right+=pourcent($mr,$ml,$mr);
                        $score+=pourcent($s,$ml,$mr);
                    }
                    
                    $pos+=count($t);
                }
            }
            
            $realscore=0;
            
            if($score<0)
                $realscore=round(-$score/$left*100);
            
            if($score>0)
                $realscore=round($score/$right*100);

            if($title!="")
                echo("<br /><br /><br /><h3>$title</h3><br />");
            
            
            echo("<p class='descr'>$descr</p>");
            
            echo("<br /><br />Score minimum : $left<br />");
            echo("Score maximum : $right<br />");
            
            echo("<br />Votre score : $score ($realscore%)<br /><br />");
            
            echo("<br />Positionnement sur l'axe <span class='axe'>$axe</span> : <br /><br /><br /><br />". generateGraph($left, $right, $score)."<br /><br /><br />");
            
            return $pos+count($tab);
        }
        
        
    
        if(!isset($_GET["quest"]))
            $quest=0;
        
        else
        {
            // session
            
            $quest=$_GET["quest"];
            
            $_SESSION["rad".($quest-1)]=$_GET["rad"];
        }
        
        
        
        $nbrquest=count($coco) + count($decentr) + count($educ) + count($hiera) + count($lib) + count($just) + count($eco) + count($imi) + count($demo);
        
        // dernière question
        if($quest>=$nbrquest)
        {
            // on stock les réponses successives dans la session au cours du questionnaire
            // puis, une fois le questionnaire fini, on fait une grosse url avec les variables contenues dans la session
            
            
            echo '<script language = "javascript">';
            
            $get="zetest.php?result=1";
            
            $get="";
            
            for($pos=0;$pos<$nbrquest;$pos++)
                $get.="a";
            
            
            for($pos=0;$pos<$nbrquest;$pos++)
            //foreach($_SESSION as $n => $v)
            {
                //$get.="&$n=$v";
                
                if(isset($_SESSION["rad$pos"]) && $_SESSION["rad$pos"]!=-1)
                {
                    $get[$pos]=$_SESSION["rad$pos"];
                }
                
                //echo("$pos ".$get[$pos]." --> ".$get."<br />");
            }
            
            $get="zetest.php?result=$get";
            
            //echo $get;
            
            echo "location.href = '$get'; ";
            
            echo '</script>';
            
            return ;
        }
        
        
        if(isset($_GET["result"]))
        {
            //print_r($_SESSION);
            
            $res=$_GET["result"];
            
            if($res!="1") // retrocompatibilité
            {
                for($pos=0;$pos<strlen($res);$pos++)
                {
                    if($res[$pos]!="a")
                        $_GET["rad$pos"]=$res[$pos];
                    
                    else
                        $_GET["rad$pos"]="-1";
                    
                    //echo("$pos --> ".$_GET["rad$pos"]."<br />");
                }
            }
            
            echo("<div class='quest'>");

            
            echo("<h2>Courage, c'est fini ! Voici maintenant vos résultats :</h2><br /><br />");
            
            
            $pos=0;
            
            echo("<br /><br /><br /><div class='resulttitle'>I) Positionnement sur l'axe Economie</div>");
            
            $pos=writeResult("Rapports de production", "La gauche aura tendance à être plus interventionniste, plus sociale, plus attachée aux services publics, à la lutte contres les inégalités et à la redistribution des richesses.<br />La droite sera plus partisante du libre-échange, de la dérégulation, de la défense du droit de propriété et des impôts faibles.", "Socialiste / Capitaliste - Libéral", $coco, $pos);
            $pos=writeResult("Décentralisation", "Utile, par exemple, pour faire la différence entre les communistes libertaires et les socialistes étatistes, ou entre les libéraux et les gaullistes.<br /> La gauche défendra plutôt la décentralisation économique et politique, alors que la droite voudra une plus grande centralisation au niveau national.", "Décentralisateur / Centralisateur - Etatiste", $decentr, $pos);
            $pos=writeResult("Education", "Les valeurs éducatives de la gauche seront plus tournées vers l'être humain, l'autonomie, la pédagogie, l'égalité et le combat pour une éducation nationale indépendante des entreprises privées.<br />Les valeurs de la droite, elles, seront plutôt tournées vers des méthodes éducatives traditionnelles, l'autorité, la discipline et l'ouverture au monde du travail.", "Humaniste - Pédagogue / Traditionnaliste - Pro-entreprise", $educ, $pos);
            
            writeResult("Positionnement général", "", "", array_merge($coco, $decentr, $educ), 0);
            $pos2=$pos;
            
            
            echo("<br /><br /><br /><br /><br /><br /><div class='resulttitle'>II) Positionnement sur l'axe Liberté</div>");
            
            $pos=writeResult("Rapport à l'autorité", "Un positionnement de gauche sera plus libertaire, plus anti-hiérarchie, plus anti-conformiste.<br />Un positionnement de droite, en revanche, sera plus respectueux de l'autorité et de la hiérarchie.", "Libertaire - Autonome / Autoritaire - Soumis", $hiera, $pos);
            $pos=writeResult("Libertés individuelles", "La gauche défendra les libertés individuelles, la libre sexualité, la liberté de disposer de son corps.<br />La droite, à l'inverse, sera plus conservatrice et défendra l'ordre social traditionnel.", "Progressiste / Réactionnaire", $lib, $pos);
            $pos=writeResult("Morale & Justice", "Alors que la gauche sera moins moraliste, plus tournée vers la prévention et l'aide sociale que vers la répression, la droite sera plus axée sur l'affirmation de la loi, de l'armée, de la police et la responsabilité individuelle.", "Autodiscipline / Conservateur - Légaliste", $just, $pos);
            
            writeResult("Positionnement général", "", "", array_merge($hiera, $lib, $just), $pos2);
            $pos2=$pos;
            
            
            echo("<br /><br /><br /><br /><br /><br /><div class='resulttitle'>III) Positionnement sur l'axe Société</div>");
            
            $pos=writeResult("Ecologisme", "La gauche luttera contre les \"excès du capitalisme\", tels que le productivisme, le consumérisme, la surproduction, les gaspillages, l'obsolescence programmée,...<br />La droite se voudra plus \"pragmatique\", plus matérialiste, plus attachée à la bonne santé de l'économie et comptera sur les entreprises privées et les bienfaits du marché libre pour prendre soin de la planète.", "Ecologiste / Consumériste - Productiviste", $eco, $pos);
            $pos=writeResult("Ouverture vers l'étranger", "La gauche se voudra internationaliste, altermondialiste, pour l'ouverture des frontières humaines et le mélange des cultures.<br />La droite sera plus nationaliste, plus protectionniste, plus chauvine, plus attachée à la défense de l'identité nationale, ceci pouvant aller parfois jusqu'à la xénophobie.", "Internationaliste - Mondialiste / Nationaliste",$imi, $pos);
            $pos=writeResult("Démocratie", "La gauche sera attachée à un plus grand contrôle du peuple sur la politique, et à une gestion plus décentralisée de celle-ci. La position la plus à gauche serait la défense de la démocratie directe.<br />La droite, quant à elle, sera d'avantage attirée par un pouvoir fort, centralisé, efficace.", "Démocrate / Autoritaire", $demo, $pos);
            
            writeResult("Positionnement général", "", "", array_merge($eco, $imi, $demo), $pos2);
            $pos2=$pos;
            
            
            
            echo("<br /><br /><br /><br /><br /><br /><div class='resulttitle'>IV) Positionnement global</div><br />");
            
            writeResult("Attention :", "Devant le grand nombre d'éléments mélangés ici, ce résultat est à prendre avec d'infinies précautions, en particulier si vous vous situez de côtés différents selon les axes principaux.<br />Ces grands axes sont donc à préférer à ce \"pot-pourri\".", "Gauche / Droite", array_merge($coco, $decentr, $educ, $hiera, $lib, $just, $eco, $imi, $demo), 0);
            //writeFinalResult("Attention :", "Devant le grand nombre d'éléments mélangés ici, ce résultat est à prendre avec d'infinies précautions, en particulier si vous vous situez de côtés différents selon les axes principaux.<br />Ces grands axes sont donc à préférer à ce \"pot-pourri\".", "Gauche / Droite");

            $pos2=$pos;
            
            
            //echo("<br /><br /><br /><br /><br /><br /><h2>Site en développement. Bientôt : une sélection des partis et organisations vous correspondant au mieux.</h2><br /><br />");
            
            
            
            echo("<br /><br /><br /><br /><br /><br /><div class='resulttitle'>V) Partis et organisations</div><br /><br /><br /><br />");
            
            echo("Voici une sélection des partis et organisations qui semblent le mieux correspondre à votre profil politique.<br /><br /><br /><br />");
            
            $partis=calculParti();
            $mp=getMeilleursPartis($partis);
            
            if(count($mp)==0)
            {
                echo "Aucun parti ne vous correspond.<br />";
            }
            
            else
            {
                foreach($mp as $p)
                {
                    echo "<h3><a href='".$p[1]["lien"]."'>".$p[1]["nom"]."</a></h3><br />";
                    echo("<div class='descr'>");
                    echo("Score : ".$p[0]."%<br />");
                    echo("Positionnement : ".$p[1]["pos"]."<br /><br />");
                    echo($p[1]["descr"]."<br />");
                    echo("</div>");
                    
                    echo("<br /><br />Positionnement sur l'axe <span class='axe'>Economie</span> : <br /><br /><br /><br />". generateGraph(-100, 100, $p[1]["axeeco"][0],  $p[1]["axeeco"][1],  $p[1]["axeeco"][2])."<br /><br /><br />");
                    echo("<br /><br />Positionnement sur l'axe <span class='axe'>Liberté</span> : <br /><br /><br /><br />". generateGraph(-100, 100, $p[1]["axelib"][0], $p[1]["axelib"][1],  $p[1]["axelib"][2])."<br /><br /><br />");
                    echo("<br /><br />Positionnement sur l'axe <span class='axe'>Société</span> : <br /><br /><br /><br />". generateGraph(-100, 100, $p[1]["axesoc"][0], $p[1]["axesoc"][1],  $p[1]["axesoc"][2])."<br /><br /><br />");


                    echo("<br /><br /><br />");
                }
            }

            
            
            echo('<br /><br />
                
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
<a class="addthis_button_preferred_1"></a>
<a class="addthis_button_preferred_2"></a>
<a class="addthis_button_preferred_3"></a>
<a class="addthis_button_preferred_4"></a>
<a class="addthis_button_compact"></a>
<a class="addthis_counter addthis_bubble_style"></a>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4f25720603bd8fc5"></script>
<!-- AddThis Button END -->

                ');
            
            echo("</div>");
            

            //session_destroy();
        }
        
    
        else
        {
            $bigtab=array_merge($coco,$decentr,$educ, $hiera, $lib, $just, $eco, $imi, $demo);
            $nbrquest=count($bigtab);
            
            
            echo "<form method='get' name='zetest' class='zetest' id='zetest' action=''>";

            echo "<input type='hidden' id='quest' name='quest' value='".($quest+1)."' />";

            $q=$bigtab[$quest];

            echo "<div class='quest' id='zequest' name='zequest'>";
            
            $nbr=$quest+1;
            
            if($nbr<10)
                $strnbrquest="0$nbr"."/".$nbrquest;
            
            else
                $strnbrquest=$nbr."/".$nbrquest;

            echo'<p class="questtitle">[ '.$strnbrquest.' ] '.$q[0]."</p>";

            $numrep=0;

            foreach($q[1] as $r)
            {
                echo '<p class="questrep"><input type="radio" id="rep'.$numrep.'" class="radinp" name="rad" value="'.$numrep.'"><label for="rep'.$numrep.'"><span class="rad">'.$r[0]."</span></label></input></p>";

                $numrep++;
            }

            echo '<p class="questrep"><input type="radio" class="radinp" name="rad" value="-1" checked><span class="rad">Autre.</span></input></p>';

            
             echo '<br /><br /><br />
                <p class="sub">
                <input type="button" id="bsub" class="bsub" value="Suivant"></input>
                </p>';
            
            
            echo "</div><br />";
        }

    ?>
    


</form>



<?php
    include("footer.php");
?>
