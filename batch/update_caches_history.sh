# script valido per la 18. legislatura

# primo anno
year=2018
for m in {4..12}
   do
     data=$(date -d "$year-01-01 +$m month -1 day" "+%Y-%m-%d")
     echo $data
     ./symfony opp-build-cache-politici --ramo=camera --data=$data
     ./symfony opp-build-cache-politici --ramo=senato --data=$data
     ./symfony opp-build-pos-cache-politici --ramo=camera --data=$data;
     ./symfony opp-build-pos-cache-politici --ramo=senato --data=$data;
     ./symfony opp-build-cache-gruppi --data=$data
     ./symfony opp-build-cache-rami --data=$data
   done

year=2019
for m in {1..06}
   do
     data=$(date -d "$year-01-01 +$m month -1 day" "+%Y-%m-%d")
     echo $data
     ./symfony opp-build-cache-politici --ramo=camera --data=$data
     ./symfony opp-build-cache-politici --ramo=senato --data=$data
     ./symfony opp-build-pos-cache-politici --ramo=camera --data=$data;
     ./symfony opp-build-pos-cache-politici --ramo=senato --data=$data;
     ./symfony opp-build-cache-gruppi --data=$data
     ./symfony opp-build-cache-rami --data=$data
   done
