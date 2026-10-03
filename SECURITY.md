<!-- ═══════════════════════════════════════════════════════════════════════ -->
<!--                       S E C U R I T Y   P O L I C Y                     -->
<!--                  Bearded Viking Security Forge                          -->
<!-- ═══════════════════════════════════════════════════════════════════════ -->

<div align="center">


 ____                       _ _         
/ ___|  ___  ___ _   _ _ __(_) |_ _   _ 
\___ \ / _ \/ __| | | | '__| | __| | | |
 ___) |  __/ (__| |_| | |  | | |_| |_| |
|____/ \___|\___|\__,_|_|  |_|\__|\__, |
                                  |___/ 

</div>
### **Security Policy & Responsible Disclosure**

**We hunt bugs for a living. We respect those who hunt ours.**

[![PGP](https://img.shields.io/badge/PGP-Encrypted%20Reports-0d1117?style=for-the-badge&logo=gnuprivacyguard&logoColor=white)](#-pgp-key--encrypted-communication)
[![Safe Harbor](https://img.shields.io/badge/Safe%20Harbor-Guaranteed-2ea043?style=for-the-badge&logo=shield&logoColor=white)](#-safe-harbor-statement)
[![Response](https://img.shields.io/badge/Response%20SLA-72%20Hours-0d1117?style=for-the-badge&logo=clock&logoColor=white)](#-our-commitment-to-you)

---

</div>

## ⚔️ Our Philosophy

We hunt vulnerabilities for a living. We file reports. We wait in disclosure queues. We know exactly what it feels like to find something serious and have it vanish into a black hole of silence.

**We refuse to be that company.**

If you take the time to responsibly disclose a vulnerability to BVSec, you will be treated with the respect, professionalism, and urgency that you deserve. You are not a threat to us. You are an ally in making our fortress stronger.

> *"The researcher who reports your bug is worth ten who don't."*

---

## 📥 How to Report a Vulnerability

**All security reports must be submitted via one of the following channels:**

| Channel | Address | Preferred For |
|:---|:---|:---|
| 📧 **Email** | `security@beardedviking.org` | All reports |
| 🔐 **PGP Encrypted Email** | See PGP section below | Sensitive findings |
| 🐙 **GitHub Private Advisory** | [Report via GitHub](https://github.com/BVSec/BVSec/security/advisories/new) | Code-level issues |
| 💬 **Signal** | Available on request | Critical / time-sensitive |

**⚠️ Do NOT open a public GitHub issue for security vulnerabilities.** Public disclosure without coordination violates this policy and voids any safe harbor consideration.

### What to Include in Your Report

To help us triage and respond quickly, please include:

1. **Summary** — A brief, clear description of the vulnerability
2. **Affected Asset(s)** — Domain, endpoint, repository, or application
3. **Vulnerability Class** — IDOR, SQLi, XSS, SSRF, auth bypass, business logic, etc.
4. **Severity Estimate** — CVSS score or your own assessment (Critical / High / Medium / Low)
5. **Reproduction Steps** — Clear, numbered steps to reproduce
6. **Proof of Concept** — Screenshots, videos, or scripts (responsible PoCs only)
7. **Impact** — What an attacker could actually do with this
8. **Suggested Remediation** *(optional)* — If you have a fix in mind
9. **Your Preferred Credit Name** — How you'd like to be credited (or request anonymity)

**Reports missing reproduction steps or impact analysis may be deprioritized.** Help us help you.

---

## 🎯 In Scope

The following assets are **in scope** for security testing:

### Primary Domains
- `beardedviking.org` and all subdomains
- `mycitadel.lol` and all subdomains
- All BVSec GitHub repositories
- All BVSec-published mobile applications (Android, iOS)

### Vulnerability Classes of Interest
- **Authentication & Authorization** — Auth bypass, session flaws, privilege escalation
- **Injection** — SQLi, NoSQLi, command injection, template injection
- **Access Control** — IDOR, broken object-level authorization (BOLA)
- **Business Logic** — Race conditions, workflow bypasses, abuse cases
- **Data Exposure** — Sensitive information disclosure, PII leakage
- **Client-Side** — XSS (stored, reflected, DOM), CSRF, clickjacking
- **Server-Side** — SSRF, XXE, deserialization, RCE
- **Cryptography** — Weak crypto, insecure key handling, padding oracles
- **API Security** — Broken object property-level auth (BOPLA), mass assignment
- **Infrastructure** — Misconfigurations, exposed services, subdomain takeover

---

## 🚫 Out of Scope

The following are considered **out of scope** and will be closed without action:

### General
- ❌ Denial of Service (DoS/DDoS) — *do not test, do not report*
- ❌ Physical attacks against any BVSec property or personnel
- ❌ Social engineering of BVSec staff, contractors, or users
- ❌ Spam, phishing simulations, or mass-email testing
- ❌ Automated scanning that generates excessive traffic
- ❌ Reports generated **solely** by automated tools without manual validation
- ❌ Vulnerabilities in third-party dependencies already publicly known (report upstream)
- ❌ Theoretical vulnerabilities without a working proof of concept

### Common Non-Issues
- ❌ Missing HTTP security headers without demonstrated impact
- ❌ Cookie flags without demonstrated exploitation
- ❌ SSL/TLS configuration opinions (B-grade scans, cipher preferences)
- ❌ Email spoofing without DMARC/DKIM bypass proof
- ❌ Clickjacking on non-sensitive pages
- ❌ Self-XSS requiring the victim to paste code into their own console
- ❌ Username/email enumeration on non-security-critical endpoints
- ❌ Rate limiting absence on non-authentication endpoints
- ❌ Password policy complaints (length, complexity, rotation)
- ❌ Version disclosure in headers or banners alone
- ❌ Best-practice recommendations without a real vulnerability
- ❌ Social media account claims, brand impersonation, or trademark issues — *contact `licensing@beardedviking.org` instead*

**If you're unsure, ask before you test.** We'd rather answer a question than process an out-of-scope report.

---

## ⏱️ Our Commitment to You

When you submit a valid report, here's what you can expect:

| Stage | Target Timeframe |
|:---|:---|
| **Initial Acknowledgment** | Within **72 hours** |
| **Triage & Severity Assessment** | Within **7 days** |
| **Status Update** | Every **7 days** until resolved |
| **Fix Deployment** | Depends on severity (see below) |
| **Disclosure Coordination** | **90 days** standard, negotiable |

### Remediation Targets by Severity

| Severity | Target Fix Time |
|:---|:---|
| 🔴 **Critical** | 24–72 hours |
| 🟠 **High** | 7 days |
| 🟡 **Medium** | 30 days |
| 🟢 **Low** | 90 days |
| ⚪ **Informational** | Best effort |

These are **targets**, not guarantees. We're a small operation, not a Fortune 500. But we will **communicate** — silence is the one thing you'll never get from us.

---

## 🛡️ Safe Harbor Statement

**We will not pursue legal action against security researchers who:**

1. Act in **good faith** to identify and report vulnerabilities
2. Follow **this policy** in full
3. **Do not** access, modify, exfiltrate, or destroy data beyond what is strictly necessary to demonstrate the vulnerability
4. **Do not** disrupt, degrade, or deny service to BVSec systems or users
5. **Do not** exploit the vulnerability for personal gain or malicious purpose
6. **Do not** publicly disclose the vulnerability before coordination with us
7. **Do not** extort, threaten, or demand payment for non-disclosure

**If you comply with this policy, BVSec will:**

- ✅ Consider your research **authorized** under applicable computer fraud statutes
- ✅ **Not** initiate or support legal action against you
- ✅ **Not** report you to law enforcement for the research itself
- ✅ Work with you in **good faith** through remediation and disclosure

**This safe harbor applies to research conducted within the In-Scope assets above. It does not protect unauthorized access, data theft, service disruption, or any action beyond demonstrating a vulnerability.**

> *We are bug bounty hunters. We know exactly what legal protection means to a researcher. We give you our word, in writing, and we mean it.*

---

## 🏆 Recognition & Credit

We believe researchers deserve credit for their work. Unless you request anonymity, we will:

- **Credit you by name (or handle) in our public Hall of Fame**
- **Reference your research in the fix changelog** where appropriate
- **Coordinate public disclosure** with you when the fix is deployed
- **Provide a written letter of acknowledgment** for your portfolio on request

### Hall of Fame

*This section will be updated as valid reports are received and resolved.*

| Researcher | Vulnerability | Severity | Date |
|:---|:---|:---:|:---|
| *Your name here?* | *Report something and find out.* | — | — |

---

## 💰 Bug Bounty Program

**At this time, BVSec does not operate a paid bug bounty program.**

We're an independent operation and every dollar goes into building better products. That said:

- **We may offer discretionary rewards** for critical findings at our sole discretion
- **We will always credit you** publicly (unless you request otherwise)
- **We will always treat your report seriously**, paid or not
- **We may refer you to third-party bounty programs** if your finding affects a partner or vendor

> *If you're hunting for cash, we respect that. If you're hunting to make things safer, we respect that more. Either way, we'll treat you right.*

**When MyCitadel reaches maturity, a paid bounty program may be introduced.** Follow this repo for updates.

---

## 🔐 PGP Key & Encrypted Communication

**We strongly encourage encrypted communications for all vulnerability reports.**

For sensitive findings, please encrypt your report using our PGP key:
-----BEGIN PGP PUBLIC KEY BLOCK-----

mDMEarbKlhYJKwYBBAHaRw8BAQdAnQW2WLgrCqGyswlXyCy1SyIvEbOXWB+xZsaE
D54QTQO0SEJlYXJkZWQgVmlraW5nIChCVlNlYyBEZXZlbG9wbWVudCBTZXJ2aWNl
cykgPHNlY3VyaXR5QGJlYXJkZWR2aWtpbmcub3JnPoiUBBMWCgA8AhsDBAsJCAcE
FQoJCAUWAgMBAAIeAQIXgBYhBBHDLSIPIdj6YY8HpBwxq7dNlv01BQJqwZZ7BQkD
zTLlAAoJEBwxq7dNlv01OQQBANRY+h36Dld2oPxJomdO7qPTp9zJrRF/sBZY8eId
EE50AQCMSx7V/jGdDbQKVXSmQTd8AKrhfRRRfITW4vjXe0xCCbg4BGq2ypYSCisG
AQQBl1UBBQEBB0AzecCxwUDSaXgTDHECnfcQgQZIeDSg1CBdSQII5KqKOgMBCAeI
eAQYFgoAIBYhBBHDLSIPIdj6YY8HpBwxq7dNlv01BQJqtsqWAhsMAAoJEBwxq7dN
lv01xrYBAM6nYY7u5/3wGcfBFw26E9Elmaq32JeXcYu3e4YXlSMvAP9iA+4T/6fw
btFS8m7nXd6/YVMyJeTM1Qudp31LjJwoDw==
=UbmZ
-----END PGP PUBLIC KEY BLOCK-----


**Key Details:**

| Field | Value |
|:---|:---|
| **Email** | `security@beardedviking.org` |
| **Key Type** | `ed25519 / cv25519` (EdDSA sign, ECDH encrypt) |
| **Key ID** | `1C31ABB74D96FD35` |
| **Fingerprint** | `11C3 2D22 0F21 D8FA 618F  07A4 1C31 ABB7 4D96 FD35` |
| **Created** | 2026-09-25 |
| **Expires** | 2028-10-03 *(after you run the fix above)* |
| **Keyserver** | [keys.openpgp.org](https://keys.openpgp.org) |

**Verify our fingerprint out-of-band before trusting this key.** We will confirm the fingerprint via a second channel (Signal, GitHub pinned post) upon request.

---

## 📜 Disclosure Timeline

Our standard coordinated disclosure process:

1. **Day 0** — You submit the report
2. **Day 0–3** — We acknowledge receipt and begin triage
3. **Day 3–7** — We confirm severity and communicate a remediation timeline
4. **Day 7–90** — We fix the issue and keep you updated weekly
5. **Day 90** — Default public disclosure date (unless otherwise agreed)

**We will always coordinate the disclosure with you.** If you want to publish your write-up, we'll help amplify it. If you want to stay silent, we'll respect that too.

**If we go silent on you** — which we won't — you are free to disclose publicly after **90 days** of no contact.

---

## ⚠️ Prohibited Activities

The following activities are **strictly prohibited** and will void all safe harbor protections:

- 🚫 **Data exfiltration** — Do not download, copy, or retain user data
- 🚫 **Data destruction** — Do not delete, modify, or corrupt any data
- 🚫 **Service disruption** — Do not DoS, DDoS, or degrade service
- 🚫 **Lateral movement** — Do not pivot to systems beyond the vulnerable asset
- 🚫 **Persistence** — Do not install backdoors, webshells, or implants
- 🚫 **Privilege retention** — Do not maintain access after confirming the vulnerability
- 🚫 **User targeting** — Do not target individual users, employees, or their accounts
- 🚫 **Extortion** — Do not demand payment in exchange for non-disclosure
- 🚫 **Public disclosure** without coordination — Do not post before Day 90 or without our agreement
- 🚫 **Sale of findings** — Do not sell, broker, or share the vulnerability with third parties

**Violation of any of the above will result in immediate legal action and referral to law enforcement.**

We are hunters. We know the difference between a researcher and a criminal. So do the courts.

---

## 📬 Contact Summary

<div align="center">

| Purpose | Contact |
|:---|:---|
| 🛡️ **Security Reports** | `security@beardedviking.org` |
| 📜 **Licensing & Permissions** | `licensing@beardedviking.org` |
| 💼 **Business & Partnerships** | `contact@beardedviking.org` |
| 🐙 **GitHub Private Advisory** | [Open Advisory](https://github.com/BVSec/BVSec/security/advisories/new) |

</div>

---

## 🙏 Thank You

To every researcher who has ever responsibly disclosed a bug — to any company, anywhere — **thank you**.

You make the internet a less broken place. One report at a time.

**We see you. We respect you. We've got your back.**

---

<div align="center">

### **Hunt well. Report responsibly. Get credited.**

**— BeardedVikingTX**
bvsec@fortress:~./security−−status[OK]Disclosurepolicy:ACTIVE[OK]Safeharbor:GUARANTEED[OK]Researcherinbox:MONITORED[OK]Legalposture:ARMEDbvsec@fortress: ./security−−status[OK]Disclosurepolicy:ACTIVE[OK]Safeharbor:GUARANTEED[OK]Researcherinbox:MONITORED[OK]Legalposture:ARMEDbvsec@fortress:  _
text


**Last Updated:** 2026

</div>