# script valido per la 17. legislatura

# primo anno
year=2013
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

for year in 2014 2015
   do
for m in {1..12}
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
done

year=2016
for m in {1..12}
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

year=2017
for m in {1..3}
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


