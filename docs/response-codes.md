### [Home](../README.md) || [Getting Started](getting-started.md) ||  [LtEvent API](ltevent.md) || [LtListener API](ltlistener.md) ||  [LtDispatcher API](ltdispatcher.md)|| [Response Codes](response-codes.md) || [Configuration](configuration.md)  || [Architecture](architecture.md) 
---

# Response Codes Management

## Overview
the response code comes with four parameters which are responseResult, ResponseCode,responseCategory and responseData
the responsse category has two values 100 for fail while 200 for succes,
response code is in 4 digit between the range of 3800 to 3900 for those that want to contribute
response result is the string result of the message
response data is the avalilablity of data probablit wocing with the response

## EventConfig / File / JSON Codes

| Code | Category | Current Result |
|---|---|---|
| 3800 | 100 | Generic package error default |
| 3805 | 100 | Unable to read file |
| 3806 | 200 | Empty file, default structure returned |
| 3807 | 100 | Invalid JSON structure in file |
| 3808 | 200 | JSON loaded successfully |
| 3809 | 100 | Unable to encode JSON for file |
| 3810 | 100 | Unable to write file |
| 3811 | 200 | JSON saved successfully |

## File Preparation Codes

| Code | Category | Current Result |
|---|---|---|
| 3812 | 100 | Unable to create directory |
| 3813 | 100 | Unable to encode initial JSON |
| 3814 | 100 | Unable to create file |
| 3815 | 200 | File ready |

## Lookup Codes

| Code | Category | Current Result |
|---|---|---|
| 3821 | 100 | Listener not found |
| 3822 | 100 | Event not found |
| 3825 | 200 | Event found |
| 3826 | 200 | Listener found |

> Note: in the current implementation, the success message for `3825` and `3826` is the numeric index as a string, while the response data contains the real index.

## Event Operation Codes

| Code | Category | Current Result |
|---|---|---|
| 3820 | 100 | Event already exists |
| 3827 | 100 | Listener already linked to event |
| 3828 | 200 | Listener linked to event successfully |
| 3829 | 100 | Listener is not linked to event |
| 3830 | 200 | Listener removed from event successfully |
| 3831 | 200 | Event deleted successfully |
| 3832 | 100 | Listeners must be an array |
| 3833 | 200 | Event updated successfully |
| 3837 | 200 | Events loaded successfully |
| 3862 | 200 | Event registered successfully |

## Listener Operation Codes

| Code | Category | Current Result |
|---|---|---|
| 3823 | 100 | Listener already exists |
| 3832 | 200 | Listener deleted successfully |
| 3833 | 200 | Listener updated successfully |
| 3838 | 200 | Listeners loaded successfully |
| 3863 | 200 | Listener registered successfully |

## Dispatcher Codes

| Code | Category | Current Result |
|---|---|---|
| 3834 | 100 | Event is disabled |
| 3835 | 200 | No listeners attached to event |
| 3836 | 200 | Event dispatched successfully |

## EventSetting Codes

| Code | Category | Current Result |
|---|---|---|
| 3840 | 100 | Unable to create settings directory |
| 3841 | 100 | Unable to encode settings JSON |
| 3842 | 100 | Unable to save settings file |
| 3843 | 200 | Settings saved successfully |

## Important Note About Duplicates

Some response codes are reused in more than one context:

- `3811` is both **JSON saved successfully** and used previously in event-related success discussions, but the current code now uses `3862` for event registration.
- `3832` is used for both:
  - event update error: `Listeners must be an array`
  - listener delete success: `Listener deleted successfully`
- `3833` is used for both:
  - event updated successfully
  - listener updated successfully

For a public package release, it would be better to normalize these into unique codes.
