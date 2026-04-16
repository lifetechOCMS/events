# 🤝 Contributing to LifeTech Events

Thank you for your interest in contributing to **LifeTech Events** 🎉

We welcome contributions from developers of all levels. This guide will help you get started quickly and follow the project standards.

---

## 📌 Contribution Workflow

1. Fork the repository  
2. Clone your fork  

```bash
git clone https://github.com/YOUR-USERNAME/events.git
```

3. Create a new branch  

```bash
git checkout -b feature/your-feature-name
```

4. Make your changes  
5. Commit your changes  

```bash
git commit -m "Add: your feature description"
```

6. Push to your fork  

```bash
git push origin feature/your-feature-name
```

7. Open a Pull Request (PR)

---

## 🧱 Project Structure

```
src/        → core package logic  
docs/       → documentation  
examples/   → usage examples  
storage/    → runtime JSON storage (ignored in git)  
```

---

## 🧠 Coding Guidelines

- Follow **PSR-4 autoloading**
- Use clear and descriptive variable names
- Keep methods small and focused
- Maintain consistency with existing code style
- Use `EventConfig::success()` and `EventConfig::error()` for responses

---

## 🔁 Response System

All responses must follow:

```php
[
  'responseResult' => '...',
  'responseCode' => 'XXXX',
  'responseCategory' => '200 or 100',
  'responseData' => []
]
```

---

## 🧪 Testing

Before submitting:

- Ensure your changes do not break existing functionality  
- Run available tests (if applicable)  
- Test manually using Postman or demo scripts  

---

## 🐛 Bug Reports

When reporting a bug, include:

- PHP version  
- Package version  
- Steps to reproduce  
- Expected vs actual result  

---

## 💡 Feature Requests

- Clearly describe the feature  
- Explain the use case  
- Provide examples if possible  

---

## 🚫 What NOT to Commit

- `/vendor/`  
- `/storage/events/*.json`  
- `.env` files  
- temporary or log files  

---

## 🔒 Security Issues

If you discover a security vulnerability, please **do not open a public issue**.  
Contact the maintainer directly.

---

## 👤 Maintainer

**Ajayi Abolore A. Ajayi**  
Founder — LifeTech OCMS  

---

## ⭐ Final Note

Your contributions help improve this package for everyone 🚀  
Thank you for being part of the LifeTech ecosystem.
