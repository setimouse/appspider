for pkgname in `cat package.txt | tr -d "\r"`
do
	url="http://sj.qq.com/myapp/detail.htm?apkName="$pkgname
	echo $url
	out="package/"$pkgname
	mkdir -p $out
	curl -s -o ${out}"/qq" "$url"
done;
