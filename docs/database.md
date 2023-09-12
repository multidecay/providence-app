# Database Entity Summary

Providence have 5 table in database schema to work:

- User, storing user credential.
- Maid, collection of Device Maid configuration.
- Device, list of connected device.
- Task, the devices tasks (this probably the long list).
- Report, the devices tasks results (long as tasks).

## User

Serve for login and constraining user ownership of maid, device and task.

## Maid

Maid configuration, alongside with name, version, command, ability, note and key-pair/signature.

Maid is type of software that run on device side to communicate with Providence.

## Device

The detail of connected device and it maid signature.

## Task

Order to executed by devices.

## Report

Result of order execution by devices.
