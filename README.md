## Exercise 1: Laravel Api Endpoint & Laravel Artisan Command

We provide information about programs and apps to several services. The core information about apps can be found in the "Apps API" and the information about the authors can be found in the "Developers API". 

Each API returns the information with a specific format, that can be found in the source-api-outputs directory.

Write an API service with a `http` endpoint that given an app **id** returns its information with the [output format](#output-format):

Write an Artisan command that given an app **id** returns the same information as the `http` endpoint.

#### Output format

```json
{
  "id": "21824",
  "author_info": {
    "name": "AresGalaxy",
    "url": "https://aresgalaxy.io/"
  },
  "title": "Ares",
  "version": "2.4.0",
  "url": "http://ares.en.softonic.com",
  "short_description": "Fast and unlimited P2P file sharing",
  "license": "Free (GPL)",
  "thumbnail": "https://screenshots.en.sftcdn.net/en/scrn/21000/21824/ares-14-100x100.png",
  "rating": 8,
  "total_downloads": "4741260",
  "compatible": "Windows 2000|Windows XP|Windows Vista|Windows 7|Windows 8"
}
```

### Considerations:

* You must use Laravel as the framework and PHP as the programming language. Preferably using functionalities from PHP 8.3 or higher. 
* Currently, we are using the data from 2 APIs: "Apps API" and "Developers API". The output format is JSON. An example output is in the source-api-outputs directory. 
    * For the purpose of this exercise, you can use the files in the source-api-outputs directory as the source of the data.
* We plan to add more information from a third API soon, that will provide the information as XML (you don't need to implement this, just be prepared for it).
* The focus here should be on design, more than implementation or performance. We are less interested in seeing that this works than in seeing how you approach the problem.
* Please provide at least some unit tests (it is not required to write them for every class). Functional/Feature tests are also a plus.
* Please provide a short summary as SUMMARY_EX1.md detailing anything you think is relevant, for example:
    * Installation steps
    * How to run your code / tests
    * What would you do to improve the performance/scalability?
    * What would you have done differently if you had had more time
    * Etc.

## Exercise 2: Laravel Artisan Command Detect Duplicates

**We want to detect which programs are not in our catalog to perform a more precise import without creating duplicates**. To achieve this, we have a duplicate detection system, one part of which is responsible for comparing the `publisher_url` from the source with the `publisher_url` we have in our catalog. If the `publisher_url` matches at least **85%**, the programs are considered duplicates.

The issue we are facing is that, due to the large volume of data, the detection that was previously done at database level is no longer viable because of its latency. We need to develop a new detection mechanism.

For this, the `publisher_url` data from the source and the catalog has been exported into files. The source file contains two columns: the `id_store` of the app and the `publisher_url`. The catalog file contains only one column with all the `publisher_url` values.

We need a **Laravel Artisan command** that, given these two files, outputs a file containing the `id_store` values of the programs that does **NOT** surpass the **85%** similarity threshold.

### Considerations:

* You must create a new Artisan command and add to the Laravel project in the previous exercise.
* A script must be created in an alternative language (Python, Ruby, BASH, etc.) to compare the files and generate the output file.
* This script must be included within a Laravel Artisan command.
* The focus here should be to ensure flexibility in using programming languages other than PHP, while also maintaining seamless integration of that technology within the Laravel framework.
* The **performance** of the Artisan command will be highly valued, as the goal of this command is to achieve high performance and reduce latency. The faster it executes and the fewer resources it consumes, the better.
* The **85%** similarity between publisher_url is just an approximation, and you can use any algorithm/tool to calculate the similarity.
* Please provide at least one unit test.
* Please provide a short summary as SUMMARY_EX2.md detailing anything you think is relevant, for example:
    * How to run your code / tests
    * Why did you choose the language you used for the script, and not another?
    * What would you do to improve the performance/scalability if you would not have any constraints?
    * What would you have done differently if you had had more time

* * *

Please send us a git bundle with your code. You can create a git bundle using `git bundle create your_project_name.bundle --all`
