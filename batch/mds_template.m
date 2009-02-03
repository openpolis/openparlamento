# $Id: mds.m,v 1.1 2003/08/14 19:35:48 frabcus Exp $
# Multidimensional scaling on matrix of distances between
# pairs of MPs, for some distance metric.
# Octave source file (should be compatible with Matlab)
    
# The Public Whip, Copyright (C) 2003 Francis Irving and Julian Todd
# This is free software, and you are welcome to redistribute it under
# certain conditions.  However, it comes with ABSOLUTELY NO WARRANTY.
# For details see the file LICENSE.html in the top level of the source.

s=size(D);
mps=s(1);

# perform the MDS decomposition 
A=-0.5*D.*D;
H=eye(mps) - 1/mps; # idempotent H*H=H
B=H*A*H;

# this should be a diagonal decomposition because B is symmetric 
#[U, S]=schur(B,"u");
[U, S]=eig(B);

# output data to coordinate file
ff = fopen(coords_file, "wt");
for i=1:mps
  fprintf(ff, "%d %f %f %f %s \n", i, sqrt(S(1,1))*U(i,1),sqrt(S(2,2))*U(i,2),sqrt(S(3,3))*U(i,3),ps(i,:));
endfor
fclose(ff);
  

