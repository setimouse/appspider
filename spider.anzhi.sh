for pkgname in `cat package.txt | tr -d "\r"`
do
	url="http://www.anzhi.com/pkg/"$pkgname
	echo $url
	out="package/"$pkgname
	mkdir -p $out
	curl -s -o ${out}"/anzhi" "$url"
done;
