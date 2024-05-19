<?php

    $cadeia = isset($_POST["cadeia"]) ? $_POST["cadeia"] : "";
    $array = str_split($cadeia);

    /* P = ({q, f}, {(, )}, {X, Z0}, Funções de transição, q, Z0, {f});
     * 
     * Funções de transição:
     * 
     * D(q, (, Z0) = (q, XZ0)
     * D(q, (, X) = (q, XX)
     * D(q, ), X) = (q, E)
     * D(q, E, Z0) = (f, Z0)
    */

    $pilha = array("Z0");

    for($i = 0; $i < count($array); $i++){
        $cont = 0; // para verificar se alguma transição foi realizada ou não
        if($array[$i] == "("){ // D(q, (, Z0) = (q, XZ0) e D(q, (, X) = (q, XX)
            for($j = count($pilha); $j > 0; $j--)
                $pilha[$j] = $pilha[$j - 1];
            $pilha[0] = "X";
            $cont++;
        } else if($array[$i] == ")" && $pilha[0] == "X"){ // D(q, ), X) = (q, E)
            for($j = 0; $j < (count($pilha) - 1); $j++)
                $pilha[$j] = $pilha[$j + 1];
            $pilha[count($pilha) - 1] = null;
            $cont++;
        } else{
            break;
        }
    }

    if($pilha[0] == "Z0" && $cont > 0) // D(q, E, Z0) = (f, Z0)
        $valida = true;
    else
        $valida = false;
    
    header("location: index.php?cadeia=$cadeia&valida=$valida");
?>