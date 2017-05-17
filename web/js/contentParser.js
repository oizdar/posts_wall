class ContentParser
{
    static parseLinks(content)
    {
        let replacePattern = /(\b(https?:\/\/www.youtube.com\/)(watch)([-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|]))/gim;
        content = content.replace(replacePattern, '<iframe width="560" height="315" src="$2embed$4" frameborder="0" allowfullscreen></iframe>')

        replacePattern = /(\b(https?:\/\/youtu.be\/)([-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|]))/gim;
        content = content.replace(replacePattern, '<iframe width="560" height="315" src="https://www.youtube.com/embed?v=$3" frameborder="0" allowfullscreen></iframe>');

        replacePattern = /((((https?|ftps?):\/\/)|(www\.))[^"<\s]+\.(jpg|jpeg|gif|tiff|bmp|png|svg))(?![^<>]*>|[^"]*?<\/(a|iframe))/gim;
        content = content.replace(replacePattern, '<img src="$1" />');

        replacePattern = /((((https?|ftps?):\/\/)|(www.))[^"<\s]+)(?![^<>]*>|[^"]*?<\/(a|iframe))/gim;
        content = content.replace(replacePattern, '<a href="$1" target="_blank">$1</a>');

        replacePattern = /\=\"www/;
        content = content.replace(replacePattern, '="http://www');

        return content;
    }
}
