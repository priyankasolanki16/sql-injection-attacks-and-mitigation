# SQL Injection Attacks and Mitigation

Controlled lab assessment of SQL injection (SQLi) and its defenses, completed in an isolated environment as part of a cybersecurity internship project.

> **Disclaimer:** All testing was done only against a local, intentionally vulnerable lab application (Skillogic SQL injection lab dataset), for learning purposes.
> The `vulnerable_*` files are intentionally insecure. Do not deploy them.

## Overview

SQL injection happens when untrusted input is placed into a SQL query in a way that changes the query's logic. This project studies how it is detected and how it is prevented, using a layered (defense in depth) approach.

## Lab Environment

| Component | Version |
|---|---|
| Operating system | Kali Linux Rolling 2026.2 |
| Web server | Apache 2.4.68 |
| Language | PHP 8.4.22 |
| Database | MariaDB 11.8.6 |
| Interception proxy | Burp Suite Community Edition |
| WAF | ModSecurity with OWASP Core Rule Set 3.3.9 |

## Architecture

```
Browser -> Burp Suite -> ModSecurity + OWASP CRS -> Apache -> PHP application -> MariaDB
```

## What I Did

- Identified SQL injection behaviour in the lab application using manual testing and Burp Suite.
- Ran a controlled UNION-based SQL injection test through Burp Suite Repeater.
- Observed ModSecurity with OWASP CRS detect the request, exceed the anomaly threshold and block it with **HTTP 403 Forbidden**.
- Reviewed the login flow and error handling for injection risk.
- Evaluated mitigations at the application and database layers.

## Mitigations Evaluated

- **Prepared statements / parameterised queries:** the primary defense. Query structure and user data are kept separate.
- **Input validation:** allow-list, type, length and format checks (a second layer, not a replacement).
- **Secure error handling:** generic messages for users, detailed logs only for administrators.
- **Least privilege:** separate, minimally privileged database accounts and secure database configuration.
- **WAF (ModSecurity + OWASP CRS):** an extra layer of defense in depth.

## Repository Contents

| File | Purpose |
|---|---|
| `vulnerable_login.php`, `vulnerable_search.php` | Intentionally vulnerable code (lab only) |
| `secure_login.php`, `secure_search.php` | Secure versions of the same pages |
| `db.php` | Database connection (credentials replaced with placeholders) |
| `index.php` | Lab application entry page |
| `EVIDENCE_INDEX.txt` | Index of the evidence files |
| `SHA256SUMS.txt` | Checksums of the evidence files |

## Limitations

- Testing was done only in an authorized, isolated lab environment.
- Least privilege and database configuration were evaluated as security controls, not exhaustively verified.
- A WAF supports secure coding but does not replace it.

## Key Takeaways

- Never build SQL by concatenating user input. Use prepared statements.
- Validate input, apply least privilege and handle errors safely.
- Combine application-level and database-level protections with a WAF and logging.
