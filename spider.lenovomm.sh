i=0
for pkgname in `cat package.txt | tr -d "\r"`
do
	url="http://www.lenovomm.com/appdetail/"$pkgname"/0"
	echo $i $url; let "i=$i+1"
	out="package/"$pkgname
	mkdir -p $out
	curl -s -o ${out}"/lenovomm" "$url"
done;
