# Response Codes Reference

This file lists the currently used response codes in the package.

## General / File / Settings Codes

| Code | Category | Meaning |
|---|---|---|
| 3800 | 100 | Generic package error |
| 3801 | 100 | Unable to create directory |
| 3802 | 100 | Unable to encode initial JSON |
| 3803 | 100 | Unable to create file |
| 3804 | 200 | File is ready |
| 3805 | 100 | Unable to read file |
| 3806 | 200 | Empty file, default structure returned |
| 3807 | 100 | Invalid JSON structure |
| 3808 | 200 | JSON loaded successfully |
| 3809 | 100 | Unable to encode JSON for save |
| 3810 | 100 | Unable to write JSON file |
| 3811 | 200 | Event registered successfully / JSON saved successfully depending on context |

## Event Codes

| Code | Category | Meaning |
|---|---|---|
| 3811 | 200 | Event registered successfully |
| 3820 | 100 | Event already exists |
| 3822 | 100 | Event not found |
| 3826 | 200 | Event found |
| 3827 | 100 | Listener already linked to event |
| 3828 | 200 | Listener linked to event successfully |
| 3829 | 100 | Listener is not linked to event |
| 3830 | 200 | Listener removed from event successfully |
| 3831 | 200 | Event deleted successfully |
| 3832 | 100 | Invalid listener array when updating event |
| 3833 | 200 | Event updated successfully |
| 3837 | 200 | Events loaded successfully |

## Listener Codes

| Code | Category | Meaning |
|---|---|---|
| 3823 | 100 | Listener already exists / Listener not found depending on context in current implementation |
| 3824 | 200 | Listener registered successfully |
| 3825 | 200 | Listener found |
| 3832 | 200 | Listener deleted successfully |
| 3833 | 200 | Listener updated successfully |
| 3838 | 200 | Listeners loaded successfully |

## Dispatcher Codes

| Code | Category | Meaning |
|---|---|---|
| 3834 | 100 | Event is disabled |
| 3835 | 200 | No listeners attached to event |
| 3836 | 200 | Event dispatched successfully |

## Settings Codes

| Code | Category | Meaning |
|---|---|---|
| 3840 | 100 | Unable to create settings directory |
| 3841 | 100 | Unable to encode settings JSON |
| 3842 | 100 | Unable to save settings file |
| 3843 | 200 | Settings saved successfully |

## Notes

Some codes are currently reused across more than one context. Before public release, it is worth normalizing them so each business outcome has a unique code.
