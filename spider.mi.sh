for pkgname in `cat package.txt | tr -d "\r"`
do
	url="http://app.mi.com/details?id="$pkgname
	echo $url
	out="package/"$pkgname
	mkdir -p $out
	curl -s -o ${out}"/mi" "$url"
done;
