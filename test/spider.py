import scrapy

class ExampleSpider(scrapy.Spider):
    name = "example"
    allowed_domains = ['funda.nl']
    start_urls = ['https://www.funda.nl/koop/rotterdam/appartement-40064886-jufferkade-89/']

    def __init__(self):
        self.path_to_html = 'index.html'

    def parse(self, response):
        with open(self.path_to_html, 'w') as html_file:
            html_file.write(response.text)
        yield {
            'url': response.url
        }