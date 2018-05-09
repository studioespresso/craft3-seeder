# Seeder plugin for Craft CMS 3.x

![Seeder](/resources/banner.png?raw=true)

### Usage

Seeder allows you to quickly create dummy entries through the command line. And you can just as easily remove the dummy data when you're done building the site.
With the plugin installed, running `./craft help seeder/generate` will show you which commands are available

#### Entries (Section ID, count)

Use the command below, followed by the ``sectionId`` and the number of entries you want to create (defaults to 20 if ommited). 

```Shell
./craft seeder/generate/entries 1 15
```

#### Categories (Category group ID, count)
```Shell
./craft seeder/generate/categories 1 10
```

#### Users (Usergroup ID, count)
```Shell
./craft seeder/generate/users 1 5
```

### Roadmap
#### Core elements
- [x] Entries
- [x] Categories
- [x] Users

- [x] Entry fields
- [ ] User fields
- [ ] Category fields
- [ ] Asset fields 

#### Core fields
- [x] Title
- [x] Plain text
- [x] Email
- [x] Url
- [x] Color
- [x] Date
- [x] Categories
- [x] Dropdown
- [x] Checkboxes
- [x] Radio buttons
- [x] Multi select
- [x] Assets
- [x] Matrix
- [x] Lightswitch
- [x] Table
- [x] Tags
- [x] Users

#### Plugin fields
- [x] [Redactor](https://github.com/craftcms/redactor)
- [x] [CKEditor](https://github.com/craftcms/ckeditor)
- [ ] [Super Table](https://github.com/verbb/super-table)