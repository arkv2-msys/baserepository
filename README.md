# Base Repository

![Build Status](https://codebuild.ap-southeast-1.amazonaws.com/badges?uuid=eyJlbmNyeXB0ZWREYXRhIjoiaGpPNW52am5HMS9pcG1iaWJsUnZTbUxJL3pWRTlMblppdXE3TlFnZ2RhNjRTa2tGY1JyQXdDRndCR0s5aERzRHd0RXFIa05La0VtZDdhU09yUWtVa01jPSIsIml2UGFyYW1ldGVyU3BlYyI6Imp1WkRvSWlkaStLSGFOWEMiLCJtYXRlcmlhbFNldFNlcmlhbCI6MX0%3D&branch=master)

## Install

- Since our repository is private, append this in your `composer.json` file

```
    "require": {
        ...
        "geekhives/baserepository": "^0.1"
    },
    {
      "repositories": [{
        "type": "composer",
        "url": "https://repo.geekhives.com"
      }]
    }
```

- Run `composer install`